<?php

namespace App\Models;

use App\Enums\BearerLevel;
use App\Models\Concerns\Publishable;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

#[Fillable(['level', 'state_association_id', 'name', 'designation', 'photo', 'sort_order', 'is_published'])]
class OfficeBearer extends Model
{
    use Publishable;

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
