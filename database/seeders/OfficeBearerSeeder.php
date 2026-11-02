<?php

namespace Database\Seeders;

use App\Enums\BearerLevel;
use App\Models\OfficeBearer;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Storage;

/**
 * Creates the national office bearers from config('jumpball.national_bearers').
 * Photos are copied from public/assets to the public disk so the admin panel
 * can replace them like any upload. Safe to run again: existing names are kept.
 */
class OfficeBearerSeeder extends Seeder
{
    public function run(): void
    {
        foreach (array_values(config('jumpball.national_bearers', [])) as $index => $bearer) {
            $exists = OfficeBearer::query()
                ->where('level', BearerLevel::National)
                ->where('name', $bearer['name'])
                ->exists();

            if ($exists) {
                continue;
            }

            OfficeBearer::query()->create([
                ...$bearer,
                'level' => BearerLevel::National,
                'photo' => $this->copyPhoto($bearer['photo'] ?? null),
                'sort_order' => $index + 1,
            ]);
        }
    }

    private function copyPhoto(?string $assetPath): ?string
    {
        if (! $assetPath || ! is_file(public_path($assetPath))) {
            return null;
        }

        $path = 'office-bearers/'.basename($assetPath);

        if (! Storage::disk('public')->exists($path)) {
            Storage::disk('public')->put($path, file_get_contents(public_path($assetPath)));
        }

        return $path;
    }
}
