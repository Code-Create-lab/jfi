<?php

namespace App\Models;

use App\Enums\RegistrationStatus;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\MorphMany;

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
        static::deleting(function (StateAssociation $association): void {
            $association->documents()->get()->each->delete();
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
