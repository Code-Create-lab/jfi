<?php

namespace App\Models;

use App\Enums\NewsType;
use App\Models\Concerns\HasSlug;
use App\Models\Concerns\Publishable;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Model;

#[Fillable(['title', 'slug', 'type', 'excerpt', 'content', 'image', 'published_on', 'is_published'])]
class News extends Model
{
    use HasSlug, Publishable;

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'type' => NewsType::class,
            'published_on' => 'date',
            'is_published' => 'boolean',
        ];
    }
}
