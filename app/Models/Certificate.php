<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Str;

/**
 * verification_code is random and used in the QR verification URL, so
 * certificates cannot be found by guessing certificate numbers.
 */
#[Fillable(['player_id', 'event_id', 'title', 'achievement', 'issued_on', 'pdf_path'])]
class Certificate extends Model
{
    protected static function booted(): void
    {
        static::creating(function (Certificate $certificate): void {
            $certificate->verification_code ??= Str::random(32);
        });

        static::created(function (Certificate $certificate): void {
            $certificate->certificate_no = sprintf(
                '%s-%s-%05d',
                config('jumpball.certificate_prefix'),
                $certificate->created_at->format('Y'),
                $certificate->getKey(),
            );

            $certificate->saveQuietly();
        });
    }

    /**
     * @return BelongsTo<Player, $this>
     */
    public function player(): BelongsTo
    {
        return $this->belongsTo(Player::class);
    }

    /**
     * @return BelongsTo<Event, $this>
     */
    public function event(): BelongsTo
    {
        return $this->belongsTo(Event::class);
    }

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'issued_on' => 'date',
        ];
    }
}
