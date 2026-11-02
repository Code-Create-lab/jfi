<?php

namespace App\Models\Concerns;

use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

/**
 * Deletes uploaded files when they are replaced or when the model is deleted.
 * Models list their file columns in storedFiles() as attribute => disk.
 * Paths starting with "assets/" ship with the site and are never deleted.
 */
trait DeletesStoredFiles
{
    /**
     * @return array<string, string>
     */
    abstract protected function storedFiles(): array;

    protected static function bootDeletesStoredFiles(): void
    {
        static::updated(function (self $model): void {
            foreach ($model->storedFiles() as $attribute => $disk) {
                if ($model->wasChanged($attribute)) {
                    static::deleteStoredFile($disk, $model->getOriginal($attribute));
                }
            }
        });

        static::deleted(function (self $model): void {
            foreach ($model->storedFiles() as $attribute => $disk) {
                static::deleteStoredFile($disk, $model->getAttribute($attribute));
            }
        });
    }

    private static function deleteStoredFile(string $disk, mixed $path): void
    {
        if (is_string($path) && $path !== '' && ! Str::startsWith($path, 'assets/')) {
            Storage::disk($disk)->delete($path);
        }
    }
}
