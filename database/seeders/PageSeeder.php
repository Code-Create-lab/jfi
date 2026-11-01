<?php

namespace Database\Seeders;

use App\Models\Page;
use Illuminate\Database\Seeder;

class PageSeeder extends Seeder
{
    /**
     * Create the editable static pages with placeholder text. Existing pages
     * are left untouched so admin edits survive a re-run.
     */
    public function run(): void
    {
        $pages = [
            'about-federation' => 'About the Federation',
            'about-jumpball' => 'About Jumpball',
            'president-message' => "President's Message",
            'privacy-policy' => 'Privacy Policy',
            'terms-and-conditions' => 'Terms & Conditions',
        ];

        foreach ($pages as $slug => $title) {
            Page::query()->firstOrCreate(['slug' => $slug], [
                'title' => $title,
                'content' => '<p>Placeholder text. Replace with the content supplied by the federation.</p>',
                'meta_title' => $title,
            ]);
        }
    }
}
