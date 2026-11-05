<?php

namespace App\Filament\Resources\Certificates\Tables;

use App\Filament\Resources\Certificates\CertificateResource;
use App\Models\Certificate;
use Filament\Actions\ActionGroup;
use Filament\Actions\DeleteAction;
use Filament\Actions\EditAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;

/**
 * Certificates are issued, downloaded and regenerated one at a time:
 * there are deliberately no bulk actions (bulk generation is out of scope).
 */
class CertificatesTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->modifyQueryUsing(fn (Builder $query) => $query->with(['player', 'event']))
            ->defaultSort('issued_on', 'desc')
            ->columns([
                TextColumn::make('certificate_no')
                    ->label('Certificate No.')
                    ->searchable()
                    ->sortable()
                    ->copyable()
                    ->weight('medium'),
                TextColumn::make('player.name')
                    ->label('Player')
                    ->searchable(['name', 'registration_no'])
                    ->description(fn (Certificate $record): ?string => $record->player?->registration_no),
                TextColumn::make('title')
                    ->searchable()
                    ->wrap(),
                TextColumn::make('achievement')
                    ->placeholder('-')
                    ->wrap()
                    ->toggleable(),
                TextColumn::make('event.title')
                    ->label('Event')
                    ->placeholder('-')
                    ->wrap()
                    ->toggleable(),
                TextColumn::make('issued_on')
                    ->label('Issued')
                    ->date('d M Y')
                    ->sortable(),
            ])
            ->filters([
                SelectFilter::make('event_id')
                    ->label('Event')
                    ->relationship('event', 'title')
                    ->searchable()
                    ->preload(),
            ])
            ->recordActions([
                CertificateResource::downloadAction(),
                ActionGroup::make([
                    CertificateResource::regenerateAction(),
                    EditAction::make(),
                    DeleteAction::make()
                        ->modalDescription(CertificateResource::DELETE_WARNING),
                ]),
            ])
            ->emptyStateHeading('No certificates yet')
            ->emptyStateDescription('Issue one here, or with "Issue certificate" on an approved player\'s page.');
    }
}
