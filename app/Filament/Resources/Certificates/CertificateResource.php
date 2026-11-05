<?php

namespace App\Filament\Resources\Certificates;

use App\Enums\RegistrationStatus;
use App\Filament\Resources\Certificates\Pages\CreateCertificate;
use App\Filament\Resources\Certificates\Pages\EditCertificate;
use App\Filament\Resources\Certificates\Pages\ListCertificates;
use App\Filament\Resources\Certificates\Schemas\CertificateForm;
use App\Filament\Resources\Certificates\Tables\CertificatesTable;
use App\Models\Certificate;
use App\Models\Player;
use BackedEnum;
use Filament\Actions\Action;
use Filament\Notifications\Notification;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;
use UnitEnum;

class CertificateResource extends Resource
{
    public const string DELETE_WARNING = 'This permanently deletes the certificate and its PDF. Its QR code will then show "Not a valid certificate".';

    protected static ?string $model = Certificate::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedDocumentCheck;

    protected static string|UnitEnum|null $navigationGroup = 'Registrations';

    protected static ?int $navigationSort = 3;

    protected static ?string $recordTitleAttribute = 'certificate_no';

    public static function form(Schema $schema): Schema
    {
        return CertificateForm::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return CertificatesTable::configure($table);
    }

    public static function downloadAction(): Action
    {
        return Action::make('download')
            ->label('Download PDF')
            ->icon(Heroicon::OutlinedArrowDownTray)
            ->color('gray')
            ->url(fn (Certificate $record): string => route('filament.admin.certificates.download', $record));
    }

    public static function regenerateAction(): Action
    {
        return Action::make('regenerate')
            ->icon(Heroicon::OutlinedArrowPath)
            ->color('gray')
            ->requiresConfirmation()
            ->modalDescription('Renders the PDF again from the current details, for example after the event was edited. Name corrections on the player update the PDF automatically. The certificate number and QR code stay the same.')
            ->action(function (Certificate $record): void {
                $record->generatePdf();

                Notification::make()->success()->title('PDF regenerated')->send();
            });
    }

    /**
     * "Issue certificate" on the player page; approved players only.
     */
    public static function issueAction(): Action
    {
        return Action::make('issueCertificate')
            ->label('Issue certificate')
            ->icon(Heroicon::OutlinedDocumentCheck)
            ->visible(fn (Player $record): bool => $record->status === RegistrationStatus::Approved)
            ->modalHeading(fn (Player $record): string => 'Issue a certificate to '.$record->name)
            ->modalSubmitActionLabel('Issue certificate')
            ->schema(CertificateForm::certificateFields())
            ->action(function (Player $record, array $data): void {
                $certificate = $record->certificates()->create($data);

                Notification::make()
                    ->success()
                    ->title('Certificate '.$certificate->certificate_no.' issued')
                    ->actions([
                        Action::make('download')
                            ->label('Download PDF')
                            ->url(route('filament.admin.certificates.download', $certificate)),
                    ])
                    ->send();
            });
    }

    /**
     * @return array<string>
     */
    public static function getGloballySearchableAttributes(): array
    {
        return ['certificate_no'];
    }

    public static function getPages(): array
    {
        return [
            'index' => ListCertificates::route('/'),
            'create' => CreateCertificate::route('/create'),
            'edit' => EditCertificate::route('/{record}/edit'),
        ];
    }
}
