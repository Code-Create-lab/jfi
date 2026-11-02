<?php

namespace App\Models;

use App\Models\Concerns\DeletesStoredFiles;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * Position 1 is the winner, 2 the runner-up, 3 third place and 4+ the
 * remaining standings. Ties are allowed.
 */
#[Fillable(['event_id', 'category', 'position', 'participant_name', 'state_association_id', 'score', 'remarks', 'photo'])]
class EventResult extends Model
{
    use DeletesStoredFiles;

    /**
     * "Winner", "Runner-up", "Third place", or "4th", "5th" ... for standings.
     */
    public function positionLabel(): string
    {
        return match ($this->position) {
            1 => 'Winner',
            2 => 'Runner-up',
            3 => 'Third place',
            default => $this->position.match (true) {
                in_array($this->position % 100, [11, 12, 13], true) => 'th',
                $this->position % 10 === 1 => 'st',
                $this->position % 10 === 2 => 'nd',
                $this->position % 10 === 3 => 'rd',
                default => 'th',
            },
        };
    }

    /**
     * @return BelongsTo<Event, $this>
     */
    public function event(): BelongsTo
    {
        return $this->belongsTo(Event::class);
    }

    /**
     * @return BelongsTo<StateAssociation, $this>
     */
    public function stateAssociation(): BelongsTo
    {
        return $this->belongsTo(StateAssociation::class);
    }

    /**
     * @return array<string, string>
     */
    protected function storedFiles(): array
    {
        return ['photo' => 'public'];
    }

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'position' => 'integer',
        ];
    }
}
