<?php

namespace Tests\Feature;

use App\Models\User;
use Database\Seeders\DatabaseSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Hash;
use Tests\TestCase;

class UserManagementTest extends TestCase
{
    use RefreshDatabase;

    public function test_only_admins_can_manage_users_and_developers_are_hidden_and_protected(): void
    {
        $developer = User::factory()->create(['is_admin' => true, 'is_developer' => true, 'email' => 'hidden@example.com']);
        $this->get('/admin/users')->assertRedirect('/admin/login');
        $this->actingAs(User::factory()->create())->get('/admin/users')->assertForbidden();
        $admin = User::factory()->create(['is_admin' => true]);
        $this->actingAs($admin)->get('/admin/users')->assertOk()->assertSee($admin->email)->assertDontSee($developer->email)->assertDontSee('href="http://localhost/admin/developer"', false);
        $this->get('/admin/users/'.$developer->id.'/edit')->assertNotFound();
        $this->put('/admin/users/'.$developer->id, [])->assertNotFound();
        $this->delete('/admin/users/'.$developer->id)->assertNotFound();
        $this->actingAs($developer)->get('/admin/users')->assertOk()->assertDontSee($developer->email);
        $this->get('/admin/users/'.$developer->id.'/edit')->assertNotFound();
    }

    public function test_admin_can_create_edit_reset_password_and_delete_without_assigning_developer(): void
    {
        $this->actingAs(User::factory()->create(['is_admin' => true]));
        $payload = ['name' => 'Managed account', 'email' => 'managed@example.com', 'role' => 'admin', 'password' => 'Long-password-2026', 'password_confirmation' => 'Long-password-2026', 'is_developer' => true];
        $this->get('/admin/users/create')->assertOk();
        $this->post('/admin/users', $payload)->assertSessionHasNoErrors()->assertRedirect('/admin/users');
        $user = User::where('email', $payload['email'])->firstOrFail();
        $this->assertTrue($user->is_admin);
        $this->assertFalse($user->is_developer);
        $this->assertTrue(Hash::check($payload['password'], $user->password));
        $this->get('/admin/users/'.$user->id.'/edit')->assertOk();
        $this->put('/admin/users/'.$user->id, [...$payload, 'role' => 'user', 'password' => '', 'password_confirmation' => ''])->assertSessionHasNoErrors();
        $this->assertFalse($user->fresh()->is_admin);
        $this->assertTrue(Hash::check($payload['password'], $user->fresh()->password));
        $this->put('/admin/users/'.$user->id, [...$payload, 'password' => 'Changed-password-2026', 'password_confirmation' => 'Changed-password-2026'])->assertSessionHasNoErrors();
        $this->assertTrue(Hash::check('Changed-password-2026', $user->fresh()->password));
        $this->delete('/admin/users/'.$user->id)->assertRedirect('/admin/users');
        $this->assertModelMissing($user);
    }

    public function test_validation_and_self_protection(): void
    {
        $admin = User::factory()->create(['is_admin' => true]);
        $this->actingAs($admin);
        $payload = ['name' => 'Example', 'email' => $admin->email, 'role' => 'developer', 'password' => 'short', 'password_confirmation' => 'different'];
        $this->post('/admin/users', $payload)->assertSessionHasErrors(['email', 'role', 'password']);
        $this->put('/admin/users/'.$admin->id, [...$payload, 'role' => 'user', 'password' => '', 'password_confirmation' => ''])->assertSessionHasErrors('role');
        $this->delete('/admin/users/'.$admin->id)->assertSessionHasErrors('user');
        $this->assertTrue($admin->fresh()->is_admin);
    }

    public function test_artisan_is_developer_only_and_rejects_arbitrary_commands(): void
    {
        Artisan::shouldReceive('call')->never();
        $this->get('/admin/developer')->assertRedirect('/admin/login');
        $this->actingAs(User::factory()->create(['is_admin' => true]));
        $this->get('/admin/developer')->assertForbidden();
        $this->post('/admin/developer', ['command' => 'migrate'])->assertForbidden();
        $this->actingAs(User::factory()->create(['is_admin' => true, 'is_developer' => true]));
        $this->get('/admin/developer')->assertOk()->assertSee('php artisan storage:link');
        $this->post('/admin/developer', ['command' => 'migrate:fresh'])->assertSessionHasErrors('command');
    }

    public function test_all_allowed_commands_use_fixed_arguments_and_display_results(): void
    {
        $this->actingAs(User::factory()->create(['is_admin' => true, 'is_developer' => true]));
        foreach (['migrate', 'optimize:clear', 'storage:link'] as $command) {
            Artisan::shouldReceive('call')->once()->withArgs(function ($actual, $arguments, $output) use ($command) {
                $this->assertSame($command, $actual);
                $this->assertSame($command === 'migrate' ? ['--force' => true, '--no-interaction' => true] : ['--no-interaction' => true], $arguments);
                $output->writeln('<script>escaped output</script>');

                return true;
            })->andReturn(0);
            $this->post('/admin/developer', ['command' => $command, '--path' => 'untrusted'])->assertSessionHas('command_result.successful', true);
            $this->get('/admin/developer')->assertSee('Perintah selesai')->assertSee('&lt;script&gt;', false)->assertDontSee('<script>escaped output</script>', false);
        }
    }

    public function test_command_failures_are_reported_without_exception_details(): void
    {
        $this->actingAs(User::factory()->create(['is_admin' => true, 'is_developer' => true]));
        Artisan::shouldReceive('call')->once()->andReturn(1);
        $this->post('/admin/developer', ['command' => 'storage:link'])->assertSessionHas('command_result.successful', false);
        Artisan::shouldReceive('call')->once()->andThrow(new \RuntimeException('secret exception details'));
        $this->post('/admin/developer', ['command' => 'migrate'])->assertSessionHas('command_result.successful', false);
        $this->get('/admin/developer')->assertSee('Perintah gagal')->assertDontSee('secret exception details');
    }

    public function test_existing_developer_is_promoted_by_migration_and_seeder(): void
    {
        $this->seed(DatabaseSeeder::class);
        $developer = User::where('email', '1017website@gmail.com')->firstOrFail();
        $this->assertTrue($developer->is_developer);
        $this->assertFalse(User::where('email', 'admin@ftlogistik.local')->firstOrFail()->is_developer);
        $migration = require database_path('migrations/2026_09_12_000000_add_developer_access_to_users.php');
        $migration->down();
        $migration->up();
        $this->assertTrue($developer->fresh()->is_developer);
    }

    public function test_console_errors_are_not_reported_as_success_even_with_zero_exit_code(): void
    {
        $this->actingAs(User::factory()->create(['is_admin' => true, 'is_developer' => true]));
        Artisan::shouldReceive('call')->once()->andReturnUsing(function ($command, $arguments, $output) {
            $output->writeln('   ERROR  The storage link already exists.');

            return 0;
        });
        $this->post('/admin/developer', ['command' => 'storage:link'])->assertSessionHas('command_result.successful', false);
        $this->get('/admin/developer')->assertSee('Perintah gagal: storage:link');
    }
}
