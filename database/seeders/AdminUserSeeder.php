<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;

class AdminUserSeeder extends Seeder
{
    /**
     * Create the admin account from ADMIN_EMAIL / ADMIN_PASSWORD. The
     * admin@example.com / password fallback is only used locally.
     */
    public function run(): void
    {
        $email = config('jumpball.admin.email');
        $password = config('jumpball.admin.password');

        if (blank($email) || blank($password)) {
            if (! app()->isLocal()) {
                $this->command?->warn('Admin user not created: set ADMIN_EMAIL and ADMIN_PASSWORD in .env.');

                return;
            }

            $email = 'admin@example.com';
            $password = 'password';
        }

        User::query()->firstOrCreate(
            ['email' => $email],
            ['name' => 'Administrator', 'password' => $password],
        );
    }
}
