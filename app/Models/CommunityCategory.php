<?php

namespace App\Models;

use App\Models\Concerns\HasSlug;
use App\Models\Concerns\Publishable;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

/**
 * Awareness category (e.g. player safety). Information only: there is no
 * complaint intake or case handling.
 */
#[Fillable(['name', 'slug', 'short_description', 'description', 'image', 'support_contact', 'sort_order', 'is_published'])]
class CommunityCategory extends Model
{
    use HasSlug, Publishable;

    /**
     * @return HasMany<CommunityPost, $this>
     */
    public function posts(): HasMany
    {
        return $this->hasMany(CommunityPost::class);
    }

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'sort_order' => 'integer',
            'is_published' => 'boolean',
        ];
    }

    /**
     * The attribute the slug is generated from.
     */
    protected function slugSource(): string
    {
        return 'name';
    }
}
