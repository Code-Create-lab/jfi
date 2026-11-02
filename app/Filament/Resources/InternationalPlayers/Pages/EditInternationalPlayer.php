<?php

namespace App\Filament\Resources\InternationalPlayers\Pages;

use App\Filament\Resources\InternationalPlayers\InternationalPlayerResource;
use Filament\Actions\DeleteAction;
use Filament\Resources\Pages\EditRecord;

class EditInternationalPlayer extends EditRecord
{
    protected static string $resource = InternationalPlayerResource::class;

    protected function getHeaderActions(): array
    {
        return [
            DeleteAction::make(),
        ];
    }

    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }
}
