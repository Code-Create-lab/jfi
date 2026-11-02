<?php

namespace App\Filament\Resources\Players;

use App\Enums\RegistrationStatus;
use App\Filament\Resources\Players\Pages\CreatePlayer;
use App\Filament\Resources\Players\Pages\EditPlayer;
use App\Filament\Resources\Players\Pages\ListPlayers;
use App\Filament\Resources\Players\Pages\ViewPlayer;
use App\Filament\Resources\Players\Schemas\PlayerForm;
use App\Filament\Resources\Players\Schemas\PlayerInfolist;
use App\Filament\Resources\Players\Tables\PlayersTable;
use App\Mail\RegistrationApproved;
use App\Mail\RegistrationRejected;
use App\Models\Player;
use BackedEnum;
use Filament\Actions\Action;
use Filament\Forms\Components\Textarea;
use Filament\Notifications\Notification;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;
use Illuminate\Mail\Mailable;
use Illuminate\Support\Facades\Mail;
use Throwable;
use UnitEnum;

class PlayerResource extends Resource
{
    protected static ?string $model = Player::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedIdentification;

    protected static string|UnitEnum|null $navigationGroup = 'Registrations';

    protected static ?int $navigationSort = 1;

    protected static ?string $recordTitleAttribute = 'name';

    public static function form(Schema $schema): Schema
    {
        return PlayerForm::configure($schema);
    }

    public static function infolist(Schema $schema): Schema
    {
        return PlayerInfolist::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return PlayersTable::configure($table);
    }

    /**
     * @return array<string>
     */
    public static function getGloballySearchableAttributes(): array
    {
        return ['registration_no', 'name', 'email', 'phone'];
    }

    public static function getNavigationBadge(): ?string
    {
        $pending = Player::query()->where('status', RegistrationStatus::Pending)->count();

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

    public static function approveAction(): Action
    {
        return Action::make('approve')
            ->icon(Heroicon::OutlinedCheckCircle)
            ->color('success')
            ->visible(fn (Player $record): bool => $record->status !== RegistrationStatus::Approved)
            ->modalHeading(fn (Player $record): string => 'Approve '.$record->name.'?')
            ->modalDescription('The player is emailed that the registration is approved, with their Player ID.')
            ->schema([
                Textarea::make('remarks')
                    ->label('Note to the player (optional)')
                    ->rows(3)
                    ->maxLength(1000),
            ])
            ->action(function (Player $record, array $data): void {
                $record->approve($data['remarks'] ?? null);

                static::sendStatusEmail($record, new RegistrationApproved($record), 'Player approved');
            });
    }

    public static function rejectAction(): Action
    {
        return Action::make('reject')
            ->icon(Heroicon::OutlinedXCircle)
            ->color('danger')
            ->visible(fn (Player $record): bool => $record->status !== RegistrationStatus::Rejected)
            ->modalHeading(fn (Player $record): string => 'Reject '.$record->name.'?')
            ->modalDescription('The player is emailed the reason below.')
            ->schema([
                Textarea::make('remarks')
                    ->label('Reason')
                    ->required()
                    ->rows(3)
                    ->maxLength(1000),
            ])
            ->action(function (Player $record, array $data): void {
                $record->reject($data['remarks']);

                static::sendStatusEmail($record, new RegistrationRejected($record), 'Player rejected');
            });
    }

    /**
     * The status change is already saved; a mail failure (e.g. SMTP not yet
     * configured) must not undo it, so it is reported and shown as a warning.
     */
    private static function sendStatusEmail(Player $player, Mailable $mail, string $title): void
    {
        try {
            Mail::to($player->email)->send($mail);

            Notification::make()->success()->title($title)->body('Email sent to '.$player->email.'.')->send();
        } catch (Throwable $exception) {
            report($exception);

            Notification::make()->warning()->title($title)->body('The status was saved, but the email could not be sent. Check the mail settings.')->persistent()->send();
        }
    }

    public static function getPages(): array
    {
        return [
            'index' => ListPlayers::route('/'),
            'create' => CreatePlayer::route('/create'),
            'view' => ViewPlayer::route('/{record}'),
            'edit' => EditPlayer::route('/{record}/edit'),
        ];
    }
}
