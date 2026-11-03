<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphTo;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

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
        static::updated(function (RegistrationDocument $document): void {
            if ($document->wasChanged('file_path') && $document->getOriginal('file_path')) {
                Storage::disk('local')->delete($document->getOriginal('file_path'));
            }
        });

        static::deleted(function (RegistrationDocument $document): void {
            Storage::disk('local')->delete($document->file_path);
        });
    }

    /**
     * Store uploaded files on the private disk under generated names and
     * return the attributes for documents()->createMany(). The original
     * file name is kept for display only.
     *
     * @param  array<string, UploadedFile>  $files  document type => file
     * @return list<array{document_type: string, file_path: string, original_name: string}>
     */
    public static function storeUploads(array $files, string $directory): array
    {
        return collect($files)
            ->map(fn (UploadedFile $file, string $type): array => [
                'document_type' => $type,
                'file_path' => $file->store($directory, 'local'),
                'original_name' => Str::limit($file->getClientOriginalName(), 250, ''),
            ])
            ->values()
            ->all();
    }

    /**
     * @return MorphTo<Model, $this>
     */
    public function documentable(): MorphTo
    {
        return $this->morphTo();
    }
}
