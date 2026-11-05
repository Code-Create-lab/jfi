<?php

namespace Database\Seeders;

use App\Enums\DownloadCategory;
use App\Models\Download;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Storage;

/**
 * Creates the federation's issued circulars as downloads. Files are copied
 * from public/assets to the public disk so the admin panel can replace them
 * like any upload. Safe to run again: existing titles are kept.
 */
class DownloadSeeder extends Seeder
{
    /**
     * @var list<array{title: string, category: DownloadCategory, description: string, asset: string, published_on: string}>
     */
    private const array CIRCULARS = [
        [
            'title' => 'Official Circular: 1st JFI East Zone Men\'s & Women\'s Jumpball Championship',
            'category' => DownloadCategory::Circular,
            'description' => 'Ref. No. EZ001/JFI/2026. Championship from 3 to 5 November 2026 at Kumaitha Sports Complex, Deoghar, Jharkhand. Each East Zone State Association may depute 10 players, 1 coach and 1 manager per men\'s and women\'s team.',
            'asset' => 'assets/images/jfi/notices/east-zone-championship-circular-2026.jpeg',
            'published_on' => '2026-10-07',
        ],
        [
            'title' => 'Official Circular: 1st Jumpball Federation of India Referee Clinic, 2026',
            'category' => DownloadCategory::Circular,
            'description' => 'Ref. No. JFI/RC001/2026. Online classes from 25 October to 1 November 2026, offline classes from 3 to 5 November 2026 at Kumaitha Sports Complex, Deoghar, Jharkhand. Registration fee Rs. 3,000 per referee, including the official referee kit.',
            'asset' => 'assets/images/jfi/notices/referee-clinic-circular-2026.jpeg',
            'published_on' => '2026-10-10',
        ],
    ];

    public function run(): void
    {
        foreach (self::CIRCULARS as $circular) {
            if (Download::query()->where('title', $circular['title'])->exists()) {
                continue;
            }

            $filePath = $this->copyFile($circular['asset']);

            if (! $filePath) {
                continue;
            }

            Download::query()->create([
                'title' => $circular['title'],
                'category' => $circular['category'],
                'description' => $circular['description'],
                'file_path' => $filePath,
                'published_on' => $circular['published_on'],
            ]);
        }
    }

    private function copyFile(string $assetPath): ?string
    {
        if (! is_file(public_path($assetPath))) {
            return null;
        }

        $path = 'downloads/'.basename($assetPath);

        if (! Storage::disk('public')->exists($path)) {
            Storage::disk('public')->put($path, file_get_contents(public_path($assetPath)));
        }

        return $path;
    }
}
