<?php

namespace App\Filament\Widgets;

use App\Filament\Resources\StateAssociations\StateAssociationResource;
use App\Models\StateAssociation;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Filament\Widgets\TableWidget;

class LatestAssociations extends TableWidget
{
    protected static ?int $sort = 3;

    protected static ?string $heading = 'Recent association applications';

    protected int|string|array $columnSpan = 'full';

    public function table(Table $table): Table
    {
        return $table
            ->query(fn () => StateAssociation::query()->latest()->limit(5))
            ->columns([
                TextColumn::make('name'),
                TextColumn::make('state'),
                TextColumn::make('status')->badge(),
                TextColumn::make('created_at')->label('Submitted')->since(),
            ])
            ->recordUrl(fn (StateAssociation $record): string => StateAssociationResource::getUrl('view', ['record' => $record]))
            ->paginated(false)
            ->emptyStateHeading('No association applications yet');
    }
}
