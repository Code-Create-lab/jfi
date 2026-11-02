<?php

namespace App\Models;

use App\Models\Concerns\DeletesStoredFiles;
use App\Models\Concerns\HasSlug;
use App\Models\Concerns\Publishable;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

#[Fillable(['title', 'slug', 'event_id', 'cover_image', 'is_published'])]
class Gallery extends Model
{
    use DeletesStoredFiles, HasSlug, Publishable;

    protected static function booted(): void
    {
        // Through the models (not only the FK cascade) so their files are deleted too.
        static::deleting(function (Gallery $model): void {
            $model->images()->get()->each->delete();
        });
    }

    /**
     * @return BelongsTo<Event, $this>
     */
    public function event(): BelongsTo
    {
        return $this->belongsTo(Event::class);
    }

    /**
     * @return HasMany<GalleryImage, $this>
     */
    public function images(): HasMany
    {
        return $this->hasMany(GalleryImage::class);
    }

    /**
     * @return array<string, string>
     */
    protected function storedFiles(): array
    {
        return ['cover_image' => 'public'];
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
