<?php

namespace App\Filament\Support;

use Filament\Forms\Components\RichEditor;
use Filament\Forms\Components\Select;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;

/**
 * Form fields reused across admin resources.
 */
class Fields
{
    /**
     * Rich text without file attachments: images are uploaded through each
     * module's own image field, so no orphaned editor uploads are left behind.
     */
    public static function richText(string $name): RichEditor
    {
        return RichEditor::make($name)
            ->fileAttachments(false)
            ->toolbarButtons([
                ['bold', 'italic', 'underline', 'link'],
                ['h2', 'h3'],
                ['blockquote', 'bulletList', 'orderedList', 'table'],
                ['undo', 'redo'],
            ]);
    }

    /**
     * @return array<string, string>
     */
    public static function stateOptions(): array
    {
        return collect(config('jumpball.states'))->mapWithKeys(fn (string $state): array => [$state => $state])->all();
    }

    /**
     * State association select limited to approved associations; the current
     * value stays selectable when editing a record linked to one that is not.
     */
    public static function approvedAssociationSelect(string $name = 'state_association_id'): Select
    {
        return Select::make($name)
            ->label('State association')
            ->relationship(
                'stateAssociation',
                'name',
                fn (Builder $query, ?Model $record) => $query->where(
                    fn (Builder $query) => $query
                        ->approved()
                        ->when($record?->getAttribute($name), fn (Builder $query, int $id) => $query->orWhereKey($id)),
                ),
            )
            ->helperText('Only approved associations are listed.')
            ->searchable()
            ->preload();
    }
}
