<?php

namespace Tests\Feature;

use App\Models\User;
use Database\Seeders\DatabaseSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class LocalAdminSeederTest extends TestCase
{
    use RefreshDatabase;

    public function test_seeded_accounts_can_login_and_reseeding_preserves_password_changes(): void
    {
        $this->seed(DatabaseSeeder::class);

        foreach (['admin@ftlogistik.local' => 'password', '1017website@gmail.com' => '1017Website2020.'] as $email => $password) {
            $this->post('/admin/login', compact('email', 'password'))->assertRedirect('/admin');
            $this->get('/admin')->assertOk();
            $this->post('/admin/logout');
        }

        $admin = User::where('email', 'admin@ftlogistik.local')->firstOrFail();
        $admin->password = 'Changed-password-2026';
        $admin->is_admin = false;
        $admin->save();
        $this->seed(DatabaseSeeder::class);
        $this->assertSame(2, User::count());
        $this->post('/admin/login', ['email' => $admin->email, 'password' => 'Changed-password-2026'])->assertRedirect('/admin');
    }
}
