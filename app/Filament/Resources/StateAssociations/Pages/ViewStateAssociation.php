<?php

namespace App\Filament\Resources\StateAssociations\Pages;

use App\Filament\Resources\StateAssociations\StateAssociationResource;
use Filament\Actions\EditAction;
use Filament\Resources\Pages\ViewRecord;

class ViewStateAssociation extends ViewRecord
{
    protected static string $resource = StateAssociationResource::class;

    public function getTitle(): string
    {
        return $this->getRecord()->name;
    }

    protected function getHeaderActions(): array
    {
        return [
            StateAssociationResource::approveAction(),
            StateAssociationResource::rejectAction(),
            EditAction::make(),
        ];
    }
}
