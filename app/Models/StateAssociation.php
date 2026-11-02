<?php

namespace App\Models;

use App\Enums\RegistrationStatus;
use App\Models\Concerns\Reviewable;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\MorphMany;
use Illuminate\Support\Facades\Storage;

/**
 * Filled by the State Association Registration form. Approved rows form the
 * public list of recognized associations.
 */
#[Fillable([
    'name', 'state', 'city', 'address', 'pincode', 'email', 'phone', 'president_name',
    'secretary_name', 'society_registration_no', 'logo', 'terms_accepted_at',
])]
class StateAssociation extends Model
{
    use Reviewable;

    /**
     * Mirrors the database default so a new model reports "pending" before it is refreshed.
     *
     * @var array<string, string>
     */
    protected $attributes = [
        'status' => RegistrationStatus::Pending->value,
    ];

    protected static function booted(): void
    {
        static::updated(function (StateAssociation $association): void {
            if ($association->wasChanged('logo') && $association->getOriginal('logo')) {
                Storage::disk('public')->delete($association->getOriginal('logo'));
            }
        });

        // Office bearers are deleted through their models (not only the FK
        // cascade) so their photos are removed too. Players keep their row;
        // the FK sets their state_association_id to null.
        static::deleting(function (StateAssociation $association): void {
            $association->documents()->get()->each->delete();
            $association->officeBearers()->get()->each->delete();
        });

        static::deleted(function (StateAssociation $association): void {
            if ($association->logo) {
                Storage::disk('public')->delete($association->logo);
            }
        });
    }

    /**
     * @return HasMany<Player, $this>
     */
    public function players(): HasMany
    {
        return $this->hasMany(Player::class);
    }

    /**
     * @return HasMany<OfficeBearer, $this>
     */
    public function officeBearers(): HasMany
    {
        return $this->hasMany(OfficeBearer::class);
    }

    /**
     * @return MorphMany<RegistrationDocument, $this>
     */
    public function documents(): MorphMany
    {
        return $this->morphMany(RegistrationDocument::class, 'documentable');
    }

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'status' => RegistrationStatus::class,
            'reviewed_at' => 'datetime',
            'terms_accepted_at' => 'datetime',
        ];
    }
}
