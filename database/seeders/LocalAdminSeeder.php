<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;

class LocalAdminSeeder extends Seeder
{
    public function run(): void
    {
        if (! app()->environment('local', 'testing')) {
            return;
        }

        foreach ([
            ['name' => 'Administrator FT', 'email' => 'admin@ftlogistik.local', 'password' => 'password'],
            ['name' => 'Developer 1017 Website', 'email' => '1017website@gmail.com', 'password' => '1017Website2020.'],
        ] as $account) {
            $user = User::firstOrNew(['email' => $account['email']]);

            if (! $user->exists) {
                $user->fill($account);
            }

            $user->is_admin = true;
            $user->is_developer = $account['email'] === '1017website@gmail.com';
            $user->save();
        }
    }
}
