<?php

namespace App\Filament\Resources\StateAssociations\Pages;

use App\Filament\Resources\StateAssociations\StateAssociationResource;
use Filament\Resources\Pages\CreateRecord;

/**
 * An admin-added association saves as pending, like an online application,
 * and is then approved with the Approve action (which also sends the email).
 */
class CreateStateAssociation extends CreateRecord
{
    protected static string $resource = StateAssociationResource::class;

    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('view', ['record' => $this->getRecord()]);
    }
}
