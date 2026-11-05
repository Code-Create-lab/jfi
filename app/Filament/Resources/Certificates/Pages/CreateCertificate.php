<?php

namespace App\Filament\Resources\Certificates\Pages;

use App\Filament\Resources\Certificates\CertificateResource;
use Filament\Resources\Pages\CreateRecord;

class CreateCertificate extends CreateRecord
{
    protected static string $resource = CertificateResource::class;

    protected static bool $canCreateAnother = false;

    public function getTitle(): string
    {
        return 'Issue certificate';
    }

    protected function getCreatedNotificationTitle(): ?string
    {
        return 'Certificate '.$this->getRecord()->certificate_no.' issued';
    }

    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }
}
