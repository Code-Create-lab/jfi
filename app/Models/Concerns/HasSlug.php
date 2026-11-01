<?php

namespace App\Models\Concerns;

use Illuminate\Support\Str;

/**
 * Fills an empty slug from the title (or another source attribute) and keeps
 * it unique by appending -2, -3, ... when the slug is already taken.
 */
trait HasSlug
{
    protected static function bootHasSlug(): void
    {
        static::saving(function (self $model): void {
            if (blank($model->getAttribute('slug'))) {
                $model->setAttribute('slug', $model->uniqueSlug());
            }
        });
    }

    /**
     * The attribute the slug is generated from.
     */
    protected function slugSource(): string
    {
        return 'title';
    }

    protected function uniqueSlug(): string
    {
        $base = rtrim(Str::substr(Str::slug((string) $this->getAttribute($this->slugSource())), 0, 200), '-');

        if ($base === '') {
            $base = Str::kebab(class_basename($this));
        }

        $slug = $base;
        $suffix = 2;

        while ($this->slugIsTaken($slug)) {
            $slug = $base.'-'.$suffix++;
        }

        return $slug;
    }

    private function slugIsTaken(string $slug): bool
    {
        return static::query()
            ->where('slug', $slug)
            ->when($this->exists, fn ($query) => $query->whereKeyNot($this->getKey()))
            ->exists();
    }
}
