<?php

namespace Tests\Feature;

use App\Models\QuotationRequest;
use App\Models\SiteSection;
use App\Models\User;
use Database\Seeders\CmsSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class CmsTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();
        $this->seed(CmsSeeder::class);
    }

    private function admin(): User
    {
        $user = User::factory()->create(['is_admin' => true]);
        $this->actingAs($user);

        return $user;
    }

    private function payload(string $key): array
    {
        $record = SiteSection::findOrFail($key);

        return [...$record->content, 'version' => $record->version()];
    }

    public function test_admin_requires_login_and_admin_role(): void
    {
        $this->get('/admin')->assertRedirect('/admin/login');
        $this->actingAs(User::factory()->create())->get('/admin')->assertForbidden();
        $this->put('/admin/content/hero', [])->assertForbidden();
    }

    public function test_login_logout_and_password_change(): void
    {
        $user = User::factory()->create(['is_admin' => true]);
        $this->post('/admin/login', ['email' => $user->email, 'password' => 'wrong'])->assertSessionHasErrors('email');
        $this->post('/admin/login', ['email' => $user->email, 'password' => 'password'])->assertRedirect('/admin');
        $this->assertAuthenticatedAs($user);
        $this->put('/admin/account', ['current_password' => 'password', 'password' => 'Updated-password-2026', 'password_confirmation' => 'Updated-password-2026'])->assertSessionHas('success');
        $this->post('/admin/logout')->assertRedirect('/admin/login');
        $this->assertGuest();
        $this->post('/admin/login', ['email' => $user->email, 'password' => 'Updated-password-2026'])->assertRedirect('/admin');
    }

    public function test_all_editors_and_home_render(): void
    {
        $this->admin();
        foreach (array_keys(config('cms')) as $section) {
            $this->get('/admin/content/'.$section)->assertOk()->assertSee('Simpan perubahan');
        }
        $this->get('/admin/content/unknown')->assertNotFound();
        $this->get('/')->assertOk()->assertSee('Moving business')->assertSee('name="fleet"', false);
        $this->get('/admin/requests')->assertOk()->assertSee('Belum ada permintaan');
    }

    public function test_content_updates_are_visible_and_html_is_escaped(): void
    {
        $this->admin();
        $payload = $this->payload('hero');
        $payload['fields']['field_6'] = '<script>alert(1)</script>';
        $this->put('/admin/content/hero', $payload)->assertSessionHasNoErrors()->assertRedirect();
        $this->get('/')->assertSee('&lt;script&gt;alert(1)&lt;/script&gt;', false)->assertDontSee('<script>alert(1)</script>', false);
    }

    public function test_image_upload_and_validation(): void
    {
        Storage::fake('public');
        $this->admin();
        $payload = $this->payload('header');
        $payload['uploads']['fields']['field_1'] = UploadedFile::fake()->image('logo.png');
        $this->put('/admin/content/header', $payload)->assertSessionHasNoErrors();
        $image = SiteSection::find('header')->content['fields']['field_1'];
        Storage::disk('public')->assertExists(substr($image, strlen('storage/')));
        $payload = $this->payload('header');
        $payload['uploads']['fields']['field_1'] = UploadedFile::fake()->create('bad.php', 10, 'application/x-php');
        $this->put('/admin/content/header', $payload)->assertSessionHasErrors('uploads.fields.field_1');
        $payload = $this->payload('header');
        $payload['fields']['field_1'] = '../../.env';
        $this->put('/admin/content/header', $payload)->assertSessionHasErrors('fields.field_1');
    }

    public function test_repeaters_support_add_reorder_and_remove_all(): void
    {
        $this->admin();
        $payload = $this->payload('services');
        $new = $payload['groups']['items'][0];
        $new['field_1'] = 'Layanan tambahan';
        array_unshift($payload['groups']['items'], $new);
        $this->put('/admin/content/services', $payload)->assertSessionHasNoErrors();
        $this->assertCount(6, SiteSection::find('services')->content['groups']['items']);
        $this->get('/')->assertSee('Layanan tambahan');
        $payload = $this->payload('services');
        unset($payload['groups']);
        $this->put('/admin/content/services', $payload)->assertSessionHasNoErrors();
        $this->assertSame([], SiteSection::find('services')->content['groups']['items']);
        $this->get('/')->assertOk();
    }

    public function test_repeater_image_upload_and_coordinate_validation(): void
    {
        Storage::fake('public');
        $this->admin();
        $payload = $this->payload('gallery');
        $payload['groups']['photos'][0]['field_1'] = '';
        $payload['uploads']['groups']['photos'][0]['field_1'] = UploadedFile::fake()->image('photo.jpg');
        $this->put('/admin/content/gallery', $payload)->assertSessionHasNoErrors();
        $path = SiteSection::find('gallery')->content['groups']['photos'][0]['field_1'];
        Storage::disk('public')->assertExists(substr($path, 8));
        $payload = $this->payload('gallery');
        $payload['groups']['photos'][0]['field_1'] = '';
        $this->put('/admin/content/gallery', $payload)->assertSessionHasErrors('groups.photos.0.field_1');
        $payload = $this->payload('network');
        $payload['groups']['cities'][0]['field_4'] = 100;
        $this->put('/admin/content/network', $payload)->assertSessionHasErrors('groups.cities.0.field_4');
    }

    public function test_cannot_overwrite_stale_edit_and_seeding_preserves_edits(): void
    {
        $this->admin();
        $payload = $this->payload('settings');
        $payload['fields']['title'] = 'Edited title';
        $this->put('/admin/content/settings', $payload)->assertSessionHasNoErrors();
        $this->seed(CmsSeeder::class);
        $this->assertSame('Edited title', SiteSection::find('settings')->content['fields']['title']);
        $payload['version'] = 'outdated';
        $this->put('/admin/content/settings', $payload)->assertSessionHasErrors('version');
    }

    public function test_quotation_is_validated_stored_and_managed(): void
    {
        $this->post('/quotation', [])->assertSessionHasErrors('email');
        $this->post('/quotation', [
            'company' => 'Test company', 'contact' => 'Test contact', 'email' => 'test@example.com',
            'phone' => '08123456789', 'pickup' => 'Jakarta', 'destination' => 'Surabaya',
            'fleet' => 'Fuso', 'details' => 'Test request',
        ])->assertSessionHas('quotation_success');
        $request = QuotationRequest::firstOrFail();
        $this->admin();
        $this->get('/admin/requests')->assertSee('Test company');
        $this->patch('/admin/requests/'.$request->id, ['status' => 'selesai'])->assertSessionHasNoErrors();
        $this->assertSame('selesai', $request->fresh()->status);
    }
}
