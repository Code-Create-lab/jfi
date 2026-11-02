<?php

namespace App\Filament\Resources\InternationalPlayers\Pages;

use App\Filament\Resources\InternationalPlayers\InternationalPlayerResource;
use Filament\Resources\Pages\CreateRecord;

class CreateInternationalPlayer extends CreateRecord
{
    protected static string $resource = InternationalPlayerResource::class;

    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }
}
