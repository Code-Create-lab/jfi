<?php

namespace App\Models;

use App\Models\Concerns\HasSlug;
use App\Models\Concerns\Publishable;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

#[Fillable(['community_category_id', 'title', 'slug', 'content', 'image', 'document_path', 'sort_order', 'is_published'])]
class CommunityPost extends Model
{
    use HasSlug, Publishable;

    /**
     * @return BelongsTo<CommunityCategory, $this>
     */
    public function category(): BelongsTo
    {
        return $this->belongsTo(CommunityCategory::class, 'community_category_id');
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
}
