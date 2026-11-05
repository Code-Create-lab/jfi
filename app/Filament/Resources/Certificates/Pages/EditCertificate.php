<?php

namespace App\Filament\Resources\Certificates\Pages;

use App\Filament\Resources\Certificates\CertificateResource;
use Filament\Actions\DeleteAction;
use Filament\Resources\Pages\EditRecord;

/**
 * Saving a change to the printed details renders a new PDF (Certificate model).
 */
class EditCertificate extends EditRecord
{
    protected static string $resource = CertificateResource::class;

    public function getTitle(): string
    {
        return 'Certificate '.$this->getRecord()->certificate_no;
    }

    protected function getHeaderActions(): array
    {
        return [
            CertificateResource::downloadAction(),
            CertificateResource::regenerateAction(),
            DeleteAction::make()
                ->modalDescription(CertificateResource::DELETE_WARNING),
        ];
    }

    protected function getSavedNotificationTitle(): ?string
    {
        return 'Saved. The PDF was updated.';
    }
}
