<?php

namespace App\Models;

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
