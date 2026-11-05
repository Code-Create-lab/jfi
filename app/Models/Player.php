<?php

namespace App\Models;

use App\Enums\Gender;
use App\Enums\RegistrationStatus;
use App\Models\Concerns\Reviewable;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Attributes\Hidden;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\MorphMany;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\Storage;

/**
 * The Player Database. registration_no is the public Player ID and is
 * generated right after the row is inserted.
 */
#[Fillable([
    'state_association_id', 'name', 'father_name', 'date_of_birth', 'gender', 'email', 'phone',
    'password', 'address', 'city', 'state', 'pincode', 'photo', 'terms_accepted_at',
])]
#[Hidden(['password', 'remember_token'])]
class Player extends Authenticatable
{
    use Notifiable, Reviewable;

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
        static::created(function (Player $player): void {
            $player->registration_no = sprintf(
                '%s-%s-%05d',
                config('jumpball.player_id_prefix'),
                $player->created_at->format('Y'),
                $player->getKey(),
            );

            $player->saveQuietly();
        });

        static::updated(function (Player $player): void {
            if ($player->wasChanged('photo') && $player->getOriginal('photo')) {
                Storage::disk('local')->delete($player->getOriginal('photo'));
            }
        });

        static::deleting(function (Player $player): void {
            $player->documents()->get()->each->delete();
            // Through the models, so the certificate PDFs are deleted too.
            $player->certificates()->get()->each->delete();
        });

        static::deleted(function (Player $player): void {
            if ($player->photo) {
                Storage::disk('local')->delete($player->photo);
            }
        });
    }

    /**
     * @return BelongsTo<StateAssociation, $this>
     */
    public function stateAssociation(): BelongsTo
    {
        return $this->belongsTo(StateAssociation::class);
    }

    /**
     * @return HasMany<Certificate, $this>
     */
    public function certificates(): HasMany
    {
        return $this->hasMany(Certificate::class);
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
            'date_of_birth' => 'date',
            'gender' => Gender::class,
            'password' => 'hashed',
            'status' => RegistrationStatus::class,
            'reviewed_at' => 'datetime',
            'terms_accepted_at' => 'datetime',
        ];
    }
}
