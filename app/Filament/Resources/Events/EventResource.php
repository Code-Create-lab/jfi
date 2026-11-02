<?php

namespace App\Filament\Resources\Events;

use App\Filament\Resources\Events\Pages\CreateEvent;
use App\Filament\Resources\Events\Pages\EditEvent;
use App\Filament\Resources\Events\Pages\ListEvents;
use App\Filament\Resources\Events\RelationManagers\ResultsRelationManager;
use App\Filament\Support\Fields;
use App\Models\Event;
use BackedEnum;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteAction;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Resources\Resource;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Columns\ImageColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Columns\ToggleColumn;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Filters\TernaryFilter;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use UnitEnum;

class EventResource extends Resource
{
    protected static ?string $model = Event::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedCalendarDays;

    protected static string|UnitEnum|null $navigationGroup = 'Events & Media';

    protected static ?int $navigationSort = 1;

    protected static ?string $recordTitleAttribute = 'title';

    /**
     * Badge colours for Event::period().
     *
     * @var array<string, string>
     */
    private const array PERIOD_COLORS = [
        'upcoming' => 'info',
        'current' => 'success',
        'previous' => 'gray',
    ];

    public static function form(Schema $schema): Schema
    {
        return $schema
            ->columns(3)
            ->components([
                Section::make('Event')
                    ->columns(2)
                    ->columnSpan(2)
                    ->schema([
                        TextInput::make('title')
                            ->required()
                            ->maxLength(255)
                            ->columnSpanFull(),
                        TextInput::make('slug')
                            ->label('URL slug')
                            ->maxLength(255)
                            ->alphaDash()
                            ->unique(ignoreRecord: true)
                            ->helperText('Leave blank to create it from the title.')
                            ->columnSpanFull(),
                        DatePicker::make('start_date')
                            ->required()
                            ->native(false)
                            ->displayFormat('d M Y')
                            ->live(),
                        DatePicker::make('end_date')
                            ->native(false)
                            ->displayFormat('d M Y')
                            ->afterOrEqual('start_date')
                            ->helperText('Leave blank for a single-day event.'),
                        TextInput::make('venue')
                            ->maxLength(255),
                        TextInput::make('city')
                            ->maxLength(255),
                        Select::make('state')
                            ->options(Fields::stateOptions())
                            ->searchable(),
                        Textarea::make('summary')
                            ->rows(2)
                            ->maxLength(500)
                            ->helperText('One or two sentences for event cards.')
                            ->columnSpanFull(),
                        Fields::richText('description')
                            ->columnSpanFull(),
                    ]),
                Section::make('Cover & visibility')
                    ->columnSpan(1)
                    ->schema([
                        FileUpload::make('cover_image')
                            ->image()
                            ->imageEditor()
                            ->disk('public')
                            ->directory('events')
                            ->visibility('public')
                            ->maxSize(4096)
                            ->helperText('JPG, PNG or WebP up to 4 MB. A JFI cover is used when empty.'),
                        Toggle::make('is_featured')
                            ->label('Featured on the home page'),
                        Toggle::make('is_published')
                            ->label('Show on website')
                            ->default(true),
                    ]),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->defaultSort('start_date', 'desc')
            ->modifyQueryUsing(fn (Builder $query) => $query->withCount('results'))
            ->columns([
                ImageColumn::make('cover_image')
                    ->label('Cover')
                    ->disk('public')
                    ->defaultImageUrl(asset('assets/images/jfi/cover-1.webp')),
                TextColumn::make('title')
                    ->searchable()
                    ->sortable()
                    ->wrap()
                    ->weight('medium')
                    ->description(fn (Event $record): ?string => collect([$record->venue, $record->city])->filter()->implode(', ') ?: null),
                TextColumn::make('start_date')
                    ->label('Dates')
                    ->sortable()
                    ->formatStateUsing(fn (Event $record): string => $record->dateRange()),
                TextColumn::make('period')
                    ->label('When')
                    ->badge()
                    ->state(fn (Event $record): string => $record->period())
                    ->formatStateUsing(fn (string $state): string => ucfirst($state))
                    ->color(fn (string $state): string => self::PERIOD_COLORS[$state]),
                TextColumn::make('results_count')
                    ->label('Results')
                    ->alignCenter(),
                ToggleColumn::make('is_featured')
                    ->label('Featured'),
                ToggleColumn::make('is_published')
                    ->label('On website'),
            ])
            ->filters([
                SelectFilter::make('period')
                    ->label('When')
                    ->options(['upcoming' => 'Upcoming', 'current' => 'Current', 'previous' => 'Previous'])
                    ->query(fn (Builder $query, array $data): Builder => match ($data['value'] ?? null) {
                        'upcoming' => $query->upcoming(),
                        'current' => $query->current(),
                        'previous' => $query->previous(),
                        default => $query,
                    }),
                SelectFilter::make('state')
                    ->options(Fields::stateOptions())
                    ->searchable(),
                TernaryFilter::make('is_featured')
                    ->label('Featured'),
            ])
            ->recordActions([
                EditAction::make(),
                DeleteAction::make()
                    ->modalDescription('This deletes the event and its results. Galleries, videos and certificates stay but lose the link to this event.'),
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                ]),
            ])
            ->emptyStateHeading('No events yet');
    }

    public static function getRelations(): array
    {
        return [
            ResultsRelationManager::class,
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => ListEvents::route('/'),
            'create' => CreateEvent::route('/create'),
            'edit' => EditEvent::route('/{record}/edit'),
        ];
    }
}
