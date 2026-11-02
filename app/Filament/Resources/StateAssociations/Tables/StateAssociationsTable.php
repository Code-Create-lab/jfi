<?php

namespace App\Filament\Resources\StateAssociations\Tables;

use App\Enums\RegistrationStatus;
use App\Filament\Resources\StateAssociations\StateAssociationResource;
use App\Models\StateAssociation;
use Filament\Actions\ActionGroup;
use Filament\Actions\EditAction;
use Filament\Actions\ViewAction;
use Filament\Tables\Columns\ImageColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Table;

class StateAssociationsTable
{
    public static function configure(Table $table): Table
    {
        $states = collect(config('jumpball.states'))->mapWithKeys(fn (string $state): array => [$state => $state])->all();

        return $table
            ->defaultSort('created_at', 'desc')
            ->columns([
                ImageColumn::make('logo')
                    ->disk('public')
                    ->circular()
                    ->defaultImageUrl(asset('assets/images/jfi/person-placeholder.svg')),
                TextColumn::make('name')
                    ->searchable(['name', 'email'])
                    ->sortable()
                    ->wrap()
                    ->weight('medium')
                    ->description(fn (StateAssociation $record): string => $record->email),
                TextColumn::make('phone')
                    ->searchable()
                    ->toggleable(isToggledHiddenByDefault: true),
                TextColumn::make('state')
                    ->sortable(),
                TextColumn::make('president_name')
                    ->label('President')
                    ->placeholder('-')
                    ->toggleable(),
                TextColumn::make('secretary_name')
                    ->label('Secretary')
                    ->placeholder('-')
                    ->toggleable(),
                TextColumn::make('status')
                    ->badge()
                    ->sortable(),
                TextColumn::make('created_at')
                    ->label('Submitted')
                    ->date('d M Y')
                    ->sortable(),
            ])
            ->filters([
                SelectFilter::make('status')
                    ->options(RegistrationStatus::class),
                SelectFilter::make('state')
                    ->options($states)
                    ->searchable(),
            ])
            ->recordActions([
                ViewAction::make(),
                ActionGroup::make([
                    EditAction::make(),
                    StateAssociationResource::approveAction(),
                    StateAssociationResource::rejectAction(),
                    StateAssociationResource::deleteAction(),
                ]),
            ])
            ->emptyStateHeading('No state associations yet')
            ->emptyStateDescription('Applications appear here when associations register on the website or are added by an admin.');
    }
}
