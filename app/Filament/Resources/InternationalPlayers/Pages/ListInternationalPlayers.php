<?php

namespace App\Filament\Resources\InternationalPlayers\Pages;

use App\Filament\Resources\InternationalPlayers\InternationalPlayerResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;

class ListInternationalPlayers extends ListRecords
{
    protected static string $resource = InternationalPlayerResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make(),
        ];
    }
}
