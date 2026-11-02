<?php

namespace App\Models;

use App\Models\Concerns\DeletesStoredFiles;
use App\Models\Concerns\Publishable;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Model;

/**
 * Admin-entered list of international players. Not linked to players.
 */
#[Fillable(['name', 'country', 'photo', 'details', 'sort_order', 'is_published'])]
class InternationalPlayer extends Model
{
    use DeletesStoredFiles, Publishable;

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
            'sort_order' => 'integer',
            'is_published' => 'boolean',
        ];
    }
}
