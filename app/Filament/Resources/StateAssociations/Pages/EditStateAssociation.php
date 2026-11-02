<?php

namespace App\Filament\Resources\StateAssociations\Pages;

use App\Filament\Resources\StateAssociations\StateAssociationResource;
use Filament\Actions\ViewAction;
use Filament\Resources\Pages\EditRecord;

class EditStateAssociation extends EditRecord
{
    protected static string $resource = StateAssociationResource::class;

    protected function getHeaderActions(): array
    {
        return [
            ViewAction::make(),
            StateAssociationResource::deleteAction(),
        ];
    }

    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('view', ['record' => $this->getRecord()]);
    }
}
