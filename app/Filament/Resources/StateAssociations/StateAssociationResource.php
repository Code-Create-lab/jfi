<?php

namespace App\Filament\Resources\StateAssociations;

use App\Enums\RegistrationStatus;
use App\Filament\Concerns\HasReviewActions;
use App\Filament\Resources\StateAssociations\Pages\CreateStateAssociation;
use App\Filament\Resources\StateAssociations\Pages\EditStateAssociation;
use App\Filament\Resources\StateAssociations\Pages\ListStateAssociations;
use App\Filament\Resources\StateAssociations\Pages\ViewStateAssociation;
use App\Filament\Resources\StateAssociations\Schemas\StateAssociationForm;
use App\Filament\Resources\StateAssociations\Schemas\StateAssociationInfolist;
use App\Filament\Resources\StateAssociations\Tables\StateAssociationsTable;
use App\Models\StateAssociation;
use BackedEnum;
use Filament\Actions\DeleteAction;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;
use UnitEnum;

class StateAssociationResource extends Resource
{
    use HasReviewActions;

    protected static ?string $model = StateAssociation::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedBuildingOffice2;

    protected static string|UnitEnum|null $navigationGroup = 'Registrations';

    protected static ?int $navigationSort = 2;

    protected static ?string $recordTitleAttribute = 'name';

    public static function form(Schema $schema): Schema
    {
        return StateAssociationForm::configure($schema);
    }

    public static function infolist(Schema $schema): Schema
    {
        return StateAssociationInfolist::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return StateAssociationsTable::configure($table);
    }

    /**
     * @return array<string>
     */
    public static function getGloballySearchableAttributes(): array
    {
        return ['name', 'email', 'phone'];
    }

    public static function getNavigationBadge(): ?string
    {
        $pending = StateAssociation::query()->where('status', RegistrationStatus::Pending)->count();

        return $pending > 0 ? (string) $pending : null;
    }

    public static function getNavigationBadgeColor(): string
    {
        return 'warning';
    }

    public static function getNavigationBadgeTooltip(): string
    {
        return 'Pending review';
    }

    /**
     * Spells out what the FK rules do: players keep their record but lose
     * the link (nullOnDelete); state office bearers are deleted.
     */
    public static function deleteAction(): DeleteAction
    {
        return DeleteAction::make()
            ->modalDescription(function (StateAssociation $record): string {
                $players = $record->players()->count();
                $bearers = $record->officeBearers()->count();

                return sprintf(
                    'This permanently deletes the association, its documents and logo. %d %s will stay registered but lose their link to this association, and %d state office %s will be deleted.',
                    $players,
                    str('player')->plural($players),
                    $bearers,
                    str('bearer')->plural($bearers),
                );
            });
    }

    public static function getPages(): array
    {
        return [
            'index' => ListStateAssociations::route('/'),
            'create' => CreateStateAssociation::route('/create'),
            'view' => ViewStateAssociation::route('/{record}'),
            'edit' => EditStateAssociation::route('/{record}/edit'),
        ];
    }
}
