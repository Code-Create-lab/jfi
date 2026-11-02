<?php

namespace App\Models;

use App\Enums\BearerLevel;
use App\Models\Concerns\Publishable;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

#[Fillable(['level', 'state_association_id', 'name', 'designation', 'location', 'photo', 'sort_order', 'is_published'])]
class OfficeBearer extends Model
{
    use Publishable;

    protected static function booted(): void
    {
        static::saving(function (OfficeBearer $bearer): void {
            if ($bearer->level === BearerLevel::National) {
                $bearer->state_association_id = null;
            }
        });

        static::updated(function (OfficeBearer $bearer): void {
            if ($bearer->wasChanged('photo')) {
                static::deletePhoto($bearer->getOriginal('photo'));
            }
        });

        static::deleted(function (OfficeBearer $bearer): void {
            static::deletePhoto($bearer->photo);
        });
    }

    /**
     * Published national office bearers in display order. Falls back to the
     * static list in config('jumpball.national_bearers') while the admin has
     * not added any, so the public site never shows an empty section.
     *
     * @return Collection<int, OfficeBearer>
     */
    public static function nationalForDisplay(): Collection
    {
        $bearers = static::query()
            ->where('level', BearerLevel::National)
            ->published()
            ->orderBy('sort_order')
            ->orderBy('id')
            ->get();

        return $bearers->isNotEmpty() ? $bearers : static::fallbackNational();
    }

    /**
     * Unsaved models built from config('jumpball.national_bearers').
     *
     * @return Collection<int, OfficeBearer>
     */
    public static function fallbackNational(): Collection
    {
        return new Collection(collect(config('jumpball.national_bearers', []))
            ->values()
            ->map(fn (array $bearer, int $index): OfficeBearer => new OfficeBearer([
                ...$bearer,
                'level' => BearerLevel::National,
                'sort_order' => $index + 1,
            ]))
            ->all());
    }

    /**
     * Required when level is State; enforce this in form validation.
     *
     * @return BelongsTo<StateAssociation, $this>
     */
    public function stateAssociation(): BelongsTo
    {
        return $this->belongsTo(StateAssociation::class);
    }

    /**
     * Uploaded photos live on the public disk; bundled fallback photos
     * (paths starting with "assets/") ship with the site and are never deleted.
     */
    private static function deletePhoto(?string $path): void
    {
        if ($path && ! Str::startsWith($path, 'assets/')) {
            Storage::disk('public')->delete($path);
        }
    }

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'level' => BearerLevel::class,
            'sort_order' => 'integer',
            'is_published' => 'boolean',
        ];
    }
}
