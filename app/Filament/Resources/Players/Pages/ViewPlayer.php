<?php

namespace App\Filament\Resources\Players\Pages;

use App\Filament\Resources\Certificates\CertificateResource;
use App\Filament\Resources\Players\PlayerResource;
use Filament\Actions\EditAction;
use Filament\Resources\Pages\ViewRecord;

class ViewPlayer extends ViewRecord
{
    protected static string $resource = PlayerResource::class;

    public function getTitle(): string
    {
        return $this->getRecord()->name;
    }

    protected function getHeaderActions(): array
    {
        return [
            PlayerResource::approveAction(),
            PlayerResource::rejectAction(),
            CertificateResource::issueAction(),
            EditAction::make(),
        ];
    }
}
