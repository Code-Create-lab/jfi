<?php

namespace App\Filament\Resources\InternationalPlayers;

use App\Filament\Resources\InternationalPlayers\Pages\CreateInternationalPlayer;
use App\Filament\Resources\InternationalPlayers\Pages\EditInternationalPlayer;
use App\Filament\Resources\InternationalPlayers\Pages\ListInternationalPlayers;
use App\Models\InternationalPlayer;
use BackedEnum;
use Filament\Actions\DeleteAction;
use Filament\Actions\EditAction;
use Filament\Forms\Components\FileUpload;
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
use Filament\Tables\Grouping\Group;
use Filament\Tables\Table;
use UnitEnum;

class InternationalPlayerResource extends Resource
{
    protected static ?string $model = InternationalPlayer::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedGlobeAsiaAustralia;

    protected static string|UnitEnum|null $navigationGroup = 'Federation';

    protected static ?int $navigationSort = 20;

    protected static ?string $recordTitleAttribute = 'name';

    public static function form(Schema $schema): Schema
    {
        return $schema
            ->columns(3)
            ->components([
                Section::make('Player')
                    ->columns(2)
                    ->columnSpan(2)
                    ->schema([
                        TextInput::make('name')
                            ->required()
                            ->maxLength(255),
                        TextInput::make('country')
                            ->required()
                            ->maxLength(100)
                            ->datalist(fn (): array => self::countries()),
                        Textarea::make('details')
                            ->rows(3)
                            ->maxLength(1000)
                            ->helperText('Event, team or achievement to show with the name.')
                            ->columnSpanFull(),
                        Toggle::make('is_published')
                            ->label('Show on website')
                            ->default(true),
                    ]),
                Section::make('Photo')
                    ->columnSpan(1)
                    ->schema([
                        FileUpload::make('photo')
                            ->hiddenLabel()
                            ->image()
                            ->imageEditor()
                            ->disk('public')
                            ->directory('international-players')
                            ->visibility('public')
                            ->maxSize(2048)
                            ->helperText('Optional. JPG, PNG or WebP up to 2 MB.'),
                    ]),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->defaultGroup(Group::make('country')->collapsible())
            ->groups([Group::make('country')->collapsible()])
            ->reorderable('sort_order')
            ->defaultSort('sort_order')
            ->columns([
                ImageColumn::make('photo')
                    ->disk('public')
                    ->circular()
                    ->defaultImageUrl(asset('assets/images/jfi/person-placeholder.svg')),
                TextColumn::make('name')
                    ->searchable()
                    ->weight('medium')
                    ->description(fn (InternationalPlayer $record): ?string => $record->details),
                TextColumn::make('country')
                    ->searchable()
                    ->sortable(),
                ToggleColumn::make('is_published')
                    ->label('On website'),
            ])
            ->filters([
                SelectFilter::make('country')
                    ->options(fn (): array => array_combine(self::countries(), self::countries()))
                    ->searchable(),
            ])
            ->recordActions([
                EditAction::make(),
                DeleteAction::make(),
            ])
            ->emptyStateHeading('No international players yet');
    }

    /**
     * Countries already entered, for suggestions and the filter.
     *
     * @return array<int, string>
     */
    private static function countries(): array
    {
        return InternationalPlayer::query()->distinct()->orderBy('country')->pluck('country')->all();
    }

    public static function getPages(): array
    {
        return [
            'index' => ListInternationalPlayers::route('/'),
            'create' => CreateInternationalPlayer::route('/create'),
            'edit' => EditInternationalPlayer::route('/{record}/edit'),
        ];
    }
}
