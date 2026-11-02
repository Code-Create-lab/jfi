<?php

namespace App\Filament\Resources\OfficeBearers\Pages;

use App\Filament\Resources\OfficeBearers\OfficeBearerResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;

class ListOfficeBearers extends ListRecords
{
    protected static string $resource = OfficeBearerResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make(),
        ];
    }
}
