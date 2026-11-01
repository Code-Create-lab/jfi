<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

/**
 * Model events stay enabled: slugs, Player IDs, certificate numbers and the
 * settings cache all rely on them.
 */
class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call([
            AdminUserSeeder::class,
            SettingSeeder::class,
            PageSeeder::class,
        ]);
    }
}
