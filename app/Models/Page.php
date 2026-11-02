<?php

namespace App\Models;

use App\Models\Concerns\DeletesStoredFiles;
use App\Models\Concerns\HasSlug;
use App\Models\Concerns\Publishable;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Model;

#[Fillable(['slug', 'title', 'subtitle', 'content', 'image', 'meta_title', 'meta_description', 'is_published'])]
class Page extends Model
{
    use DeletesStoredFiles, HasSlug, Publishable;

    /**
     * @return array<string, string>
     */
    protected function storedFiles(): array
    {
        return ['image' => 'public'];
    }

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'is_published' => 'boolean',
        ];
    }
}
