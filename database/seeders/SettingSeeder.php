<?php

namespace Database\Seeders;

use App\Models\Setting;
use Illuminate\Database\Seeder;

class SettingSeeder extends Seeder
{
    /**
     * Create the site settings. Existing keys are left untouched so values
     * edited in the admin panel survive a re-run.
     */
    public function run(): void
    {
        $settings = [
            'site_name' => 'Jumpball Federation of India',
            'tagline' => 'Raising the Game Across India',
            'contact_email' => 'info@example.com',
            'contact_phone' => '+91 00000 00000',
            'contact_address' => 'Address to be confirmed',
            'map_embed' => null,
            'facebook_url' => null,
            'instagram_url' => null,
            'youtube_url' => null,
            'x_url' => null,
            'footer_text' => 'Jumpball Federation of India. All rights reserved.',
            'default_meta_description' => 'Jumpball Federation of India - the national body for the development, competition and governance of Jumpball in India.',
        ];

        foreach ($settings as $key => $value) {
            Setting::query()->firstOrCreate(['key' => $key], ['value' => $value]);
        }
    }
}
