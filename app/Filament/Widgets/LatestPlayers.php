<?php

namespace App\Filament\Widgets;

use App\Models\Player;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Filament\Widgets\TableWidget;

class LatestPlayers extends TableWidget
{
    protected static ?int $sort = 2;

    protected static ?string $heading = 'Recent player registrations';

    protected int|string|array $columnSpan = 'full';

    public function table(Table $table): Table
    {
        return $table
            ->query(fn () => Player::query()->with('stateAssociation')->latest()->limit(5))
            ->columns([
                TextColumn::make('registration_no')->label('Player ID'),
                TextColumn::make('name'),
                TextColumn::make('stateAssociation.name')->label('State association')->placeholder('Not linked'),
                TextColumn::make('status')->badge(),
                TextColumn::make('created_at')->label('Submitted')->since(),
            ])
            ->paginated(false)
            ->emptyStateHeading('No player registrations yet');
    }
}
