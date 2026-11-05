<?php

namespace Tests\Feature;

use App\Enums\DownloadCategory;
use App\Models\Download;
use Database\Seeders\DownloadSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class DownloadSeederTest extends TestCase
{
    use RefreshDatabase;

    public function test_seeder_creates_circulars_with_files_once(): void
    {
        Storage::fake('public');

        $this->seed(DownloadSeeder::class);
        $this->seed(DownloadSeeder::class);

        $downloads = Download::query()->orderBy('published_on')->get();

        $this->assertCount(2, $downloads);
        $this->assertSame([DownloadCategory::Circular, DownloadCategory::Circular], $downloads->pluck('category')->all());
        $this->assertSame(['JPEG', 'JPEG'], $downloads->map->fileExtension()->all());
        Storage::disk('public')->assertExists($downloads->pluck('file_path')->all());
    }

    public function test_seeded_circulars_are_listed_on_the_downloads_page(): void
    {
        Storage::fake('public');
        $this->seed(DownloadSeeder::class);

        $this->get(route('frontend.downloads', ['category' => DownloadCategory::Circular->value]))
            ->assertOk()
            ->assertSeeInOrder(['Referee Clinic, 2026', 'East Zone Men', 'Published'], false);
    }

    public function test_view_link_is_offered_only_for_files_browsers_can_display(): void
    {
        Download::query()->create(['title' => 'Notice Image', 'category' => DownloadCategory::Notice, 'file_path' => 'downloads/notice.jpeg']);
        Download::query()->create(['title' => 'Entry Form', 'category' => DownloadCategory::Form, 'file_path' => 'downloads/entry-form.docx']);

        $this->get(route('frontend.downloads'))
            ->assertOk()
            ->assertSee('View<span class="visually-hidden"> Notice Image', false)
            ->assertDontSee('View<span class="visually-hidden"> Entry Form', false)
            ->assertSee('Download<span class="visually-hidden"> Entry Form', false);
    }
}
