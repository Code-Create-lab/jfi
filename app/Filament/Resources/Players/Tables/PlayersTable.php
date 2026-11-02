<?php

namespace App\Filament\Resources\Players\Tables;

use App\Enums\Gender;
use App\Enums\RegistrationStatus;
use App\Filament\Resources\Players\PlayerResource;
use App\Models\Player;
use Filament\Actions\Action;
use Filament\Actions\ActionGroup;
use Filament\Actions\EditAction;
use Filament\Actions\ViewAction;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Contracts\HasTable;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Symfony\Component\HttpFoundation\StreamedResponse;

class PlayersTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->modifyQueryUsing(fn (Builder $query) => $query->with('stateAssociation'))
            ->defaultSort('created_at', 'desc')
            ->columns([
                TextColumn::make('registration_no')
                    ->label('Player ID')
                    ->searchable()
                    ->sortable()
                    ->copyable()
                    ->weight('medium'),
                TextColumn::make('name')
                    ->searchable()
                    ->sortable()
                    ->description(fn (Player $record): string => $record->email),
                TextColumn::make('phone')
                    ->searchable()
                    ->toggleable(),
                TextColumn::make('stateAssociation.name')
                    ->label('State association')
                    ->placeholder('Not linked')
                    ->wrap()
                    ->toggleable(),
                TextColumn::make('gender')
                    ->toggleable(isToggledHiddenByDefault: true),
                TextColumn::make('date_of_birth')
                    ->label('Date of birth')
                    ->date('d M Y')
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                TextColumn::make('status')
                    ->badge()
                    ->sortable(),
                TextColumn::make('created_at')
                    ->label('Registered')
                    ->date('d M Y')
                    ->sortable(),
            ])
            ->filters([
                SelectFilter::make('status')
                    ->options(RegistrationStatus::class),
                SelectFilter::make('state_association_id')
                    ->label('State association')
                    ->relationship('stateAssociation', 'name')
                    ->searchable()
                    ->preload(),
                SelectFilter::make('gender')
                    ->options(Gender::class),
            ])
            ->headerActions([
                Action::make('exportCsv')
                    ->label('Export CSV')
                    ->icon(Heroicon::OutlinedArrowDownTray)
                    ->color('gray')
                    ->action(fn (HasTable $livewire): StreamedResponse => static::exportCsv($livewire->getFilteredSortedTableQuery())),
            ])
            ->recordActions([
                ViewAction::make(),
                ActionGroup::make([
                    EditAction::make(),
                    PlayerResource::approveAction(),
                    PlayerResource::rejectAction(),
                ]),
            ])
            ->emptyStateHeading('No players yet')
            ->emptyStateDescription('Players appear here when they register on the website or are added by an admin.');
    }

    /**
     * Streams the players matching the current search, filters and tab.
     */
    public static function exportCsv(Builder $query): StreamedResponse
    {
        return response()->streamDownload(function () use ($query): void {
            $out = fopen('php://output', 'w');

            fputcsv($out, ['Player ID', 'Name', "Father's name", 'Date of birth', 'Gender', 'Email', 'Phone', 'Address', 'City', 'State', 'PIN code', 'State association', 'Status', 'Registered on', 'Reviewed on', 'Remarks']);

            $query->with('stateAssociation')->lazy(500)->each(function (Player $player) use ($out): void {
                fputcsv($out, array_map(static::safeCell(...), [
                    $player->registration_no,
                    $player->name,
                    $player->father_name,
                    $player->date_of_birth?->format('Y-m-d'),
                    $player->gender?->label(),
                    $player->email,
                    $player->phone,
                    $player->address,
                    $player->city,
                    $player->state,
                    $player->pincode,
                    $player->stateAssociation?->name,
                    $player->status->label(),
                    $player->created_at?->format('Y-m-d H:i'),
                    $player->reviewed_at?->format('Y-m-d H:i'),
                    $player->admin_remarks,
                ]));
            });

            fclose($out);
        }, 'jfi-players-'.now()->format('Y-m-d').'.csv', ['Content-Type' => 'text/csv; charset=UTF-8']);
    }

    /**
     * Prevents spreadsheet formula injection from user-entered values.
     */
    private static function safeCell(mixed $value): string
    {
        $value = (string) $value;

        return $value !== '' && in_array($value[0], ['=', '+', '-', '@', "\t", "\r"], true) ? "'".$value : $value;
    }
}
