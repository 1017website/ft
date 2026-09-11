<?php

namespace Tests\Feature;

use App\Models\DailyVisitor;
use App\Models\SiteSection;
use App\Models\User;
use Database\Seeders\CmsSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class CmsAdvancedTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();
        $this->seed(CmsSeeder::class);
    }

    private function admin(): void
    {
        $this->actingAs(User::factory()->create(['is_admin' => true]));
    }

    private function payload(string $key): array
    {
        return [...SiteSection::websiteContent()[$key], 'version' => SiteSection::find($key)->version()];
    }

    public function test_visits_count_daily_views_but_exclude_admins_and_bots(): void
    {
        $this->withHeaders(['User-Agent' => 'Mobile browser'])->get('/?utm_source=newsletter')->assertOk();
        $this->get('/')->assertOk();
        $this->assertDatabaseCount('daily_visitors', 1);
        $visit = DailyVisitor::first();
        $this->assertSame(2, (int) $visit->views);
        $this->assertSame('newsletter', $visit->source);
        $this->assertSame('HP', $visit->device);
        $this->assertSame(64, strlen($visit->visitor_hash));
        $this->withHeaders(['User-Agent' => 'Googlebot'])->get('/');
        $this->admin();
        $this->withHeaders(['User-Agent' => 'Regular browser'])->get('/');
        $this->assertSame(2, (int) DailyVisitor::sum('views'));
        $this->get('/admin/statistics?days=7')->assertOk()->assertSee('newsletter');
    }

    public function test_preview_renders_unsaved_upload_and_text_without_writing(): void
    {
        Storage::fake('public');
        $this->post('/admin/preview/hero', [])->assertRedirect('/admin/login');
        $this->admin();
        $before = SiteSection::find('hero')->content;
        $payload = $this->payload('hero');
        $payload['fields']['field_6'] = 'Unsaved preview heading';
        $payload['uploads']['fields']['field_1'] = UploadedFile::fake()->image('preview.png');
        $this->post('/admin/preview/hero', $payload)->assertOk()->assertSee('Unsaved preview heading')->assertSee('data:image/png;base64,', false)->assertSee('cms-preview.js')->assertDontSee('marketingSettings')->assertHeader('X-Robots-Tag', 'noindex, nofollow');
        $this->assertSame($before, SiteSection::find('hero')->content);
        $this->assertSame([], Storage::disk('public')->allFiles());
        $this->assertDatabaseCount('daily_visitors', 0);
    }

    public function test_seo_renders_metadata_schema_and_dynamic_sitemap(): void
    {
        $this->admin();
        $payload = $this->payload('settings');
        $payload['fields']['canonical'] = 'https://ft.example/';
        $payload['fields']['og_title'] = 'Share title';
        $payload['fields']['google_verification'] = 'verification-token';
        $this->put('/admin/content/settings', $payload)->assertSessionHasNoErrors();
        $this->get('/')->assertSee('content="Share title"', false)->assertSee('href="https://ft.example/"', false)->assertSee('application/ld+json')->assertSee('verification-token');
        $this->get('/sitemap.xml')->assertOk()->assertSee('https://ft.example/', false);
        $this->get('/robots.txt')->assertOk()->assertSee('Disallow: /admin');
        $payload = $this->payload('settings');
        $payload['fields']['robots'] = 'noindex,nofollow';
        $this->put('/admin/content/settings', $payload)->assertSessionHasNoErrors();
        $this->get('/sitemap.xml')->assertDontSee('<url>', false);
        $this->get('/')->assertSee('content="noindex,nofollow"', false);
    }

    public function test_integrations_validate_ids_and_never_execute_in_preview(): void
    {
        $this->admin();
        $payload = $this->payload('integrations');
        $payload['fields']['ga4'] = '<script>bad</script>';
        $this->put('/admin/content/integrations', $payload)->assertSessionHasErrors('fields.ga4');
        $payload['fields']['ga4'] = 'G-123456ABC';
        $payload['fields']['meta_pixel'] = '1234567890';
        $this->put('/admin/content/integrations', $payload)->assertSessionHasNoErrors();
        $this->get('/')->assertSee('marketingSettings')->assertSee('trackingConsent');
        $this->post('/admin/preview/hero', $this->payload('hero'))->assertOk()->assertDontSee('marketingSettings')->assertDontSee('integrations.js');
    }

    public function test_gallery_counts_are_independent_from_template_and_brand_sizes_are_validated(): void
    {
        $this->admin();
        $payload = $this->payload('gallery');
        $payload['groups']['videos'] = array_fill(0, 7, $payload['groups']['videos'][0]);
        $payload['fields']['video_limit'] = '2';
        $this->put('/admin/content/gallery', $payload)->assertSessionHasNoErrors();
        $html = $this->get('/')->getContent();
        $this->assertSame(2, substr_count($html, 'class="video-card"'));
        $this->assertCount(7, SiteSection::find('gallery')->content['groups']['videos']);
        $payload = $this->payload('branding');
        $payload['fields']['cms_width'] = '9999';
        $this->put('/admin/content/branding', $payload)->assertSessionHasErrors('fields.cms_width');
        $payload['fields']['cms_width'] = '160';
        $this->put('/admin/content/branding', $payload)->assertSessionHasNoErrors();
        $this->get('/admin')->assertSee('width:160px', false);
    }

    public function test_new_defaults_do_not_repopulate_deleted_lists(): void
    {
        SiteSection::find('gallery')->update(['content' => ['fields' => ['field_1' => 'Custom gallery'], 'groups' => ['photos' => [], 'videos' => []]]]);
        $content = SiteSection::websiteContent()['gallery'];
        $this->assertSame('Custom gallery', $content['fields']['field_1']);
        $this->assertSame('0', $content['fields']['photo_limit']);
        $this->assertSame([], $content['groups']['photos']);
    }
}
