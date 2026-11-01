<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphTo;
use Illuminate\Support\Facades\Storage;

/**
 * An uploaded registration document for a Player or StateAssociation.
 * Files live on the private "local" disk; document_type is a key from
 * config('jumpball.player_document_types') or association_document_types.
 */
#[Fillable(['document_type', 'file_path', 'original_name'])]
class RegistrationDocument extends Model
{
    protected static function booted(): void
    {
        static::deleted(function (RegistrationDocument $document): void {
            Storage::disk('local')->delete($document->file_path);
        });
    }

    /**
     * @return MorphTo<Model, $this>
     */
    public function documentable(): MorphTo
    {
        return $this->morphTo();
    }
}
