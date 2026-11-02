<?php

namespace App\Filament\Resources\OfficeBearers\Pages;

use App\Filament\Resources\OfficeBearers\OfficeBearerResource;
use Filament\Actions\DeleteAction;
use Filament\Resources\Pages\EditRecord;

class EditOfficeBearer extends EditRecord
{
    protected static string $resource = OfficeBearerResource::class;

    protected function getHeaderActions(): array
    {
        return [
            DeleteAction::make(),
        ];
    }
}
