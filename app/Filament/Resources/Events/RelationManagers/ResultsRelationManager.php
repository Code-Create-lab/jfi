<?php

namespace App\Filament\Resources\Events\RelationManagers;

use App\Filament\Support\Fields;
use App\Models\EventResult;
use Filament\Actions\CreateAction;
use Filament\Actions\DeleteAction;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\TextInput;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Schemas\Schema;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;

class ResultsRelationManager extends RelationManager
{
    protected static string $relationship = 'results';

    protected static ?string $title = 'Championship results';

    public function form(Schema $schema): Schema
    {
        return $schema
            ->columns(2)
            ->components([
                TextInput::make('category')
                    ->maxLength(255)
                    ->placeholder('Junior Boys, Senior Women...')
                    ->datalist(fn (): array => $this->getOwnerRecord()->results()->whereNotNull('category')->distinct()->orderBy('category')->pluck('category')->all()),
                TextInput::make('position')
                    ->required()
                    ->integer()
                    ->minValue(1)
                    ->maxValue(255)
                    ->helperText('1 = Winner, 2 = Runner-up, 3 = Third place, 4 or more = standings.'),
                TextInput::make('participant_name')
                    ->label('Team / participant')
                    ->required()
                    ->maxLength(255),
                Fields::approvedAssociationSelect(),
                TextInput::make('score')
                    ->maxLength(255),
                TextInput::make('remarks')
                    ->maxLength(255),
                FileUpload::make('photo')
                    ->image()
                    ->disk('public')
                    ->directory('results')
                    ->visibility('public')
                    ->maxSize(4096)
                    ->columnSpanFull(),
            ]);
    }

    public function table(Table $table): Table
    {
        return $table
            ->recordTitleAttribute('participant_name')
            ->modifyQueryUsing(fn (Builder $query) => $query->with('stateAssociation')->orderBy('category')->orderBy('position'))
            ->columns([
                TextColumn::make('category')
                    ->placeholder('General'),
                TextColumn::make('position')
                    ->badge()
                    ->formatStateUsing(fn (EventResult $record): string => $record->positionLabel())
                    ->color(fn (int $state): string => match ($state) {
                        1 => 'warning',
                        2 => 'gray',
                        3 => 'danger',
                        default => 'primary',
                    }),
                TextColumn::make('participant_name')
                    ->label('Team / participant')
                    ->searchable(),
                TextColumn::make('stateAssociation.name')
                    ->label('State association')
                    ->placeholder('-')
                    ->wrap(),
                TextColumn::make('score')
                    ->placeholder('-'),
            ])
            ->headerActions([
                CreateAction::make()->label('Add result'),
            ])
            ->recordActions([
                EditAction::make(),
                DeleteAction::make(),
            ])
            ->toolbarActions([
                DeleteBulkAction::make(),
            ])
            ->emptyStateHeading('No results yet')
            ->emptyStateDescription('Add 1st, 2nd and 3rd place (and standings) per category.');
    }
}
