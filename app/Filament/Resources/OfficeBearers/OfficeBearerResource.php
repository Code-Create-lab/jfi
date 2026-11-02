<?php

namespace App\Filament\Resources\OfficeBearers;

use App\Enums\BearerLevel;
use App\Filament\Resources\OfficeBearers\Pages\CreateOfficeBearer;
use App\Filament\Resources\OfficeBearers\Pages\EditOfficeBearer;
use App\Filament\Resources\OfficeBearers\Pages\ListOfficeBearers;
use App\Models\OfficeBearer;
use BackedEnum;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteAction;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Resources\Resource;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Components\Utilities\Get;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Columns\ImageColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Columns\ToggleColumn;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use UnitEnum;

class OfficeBearerResource extends Resource
{
    protected static ?string $model = OfficeBearer::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedUserGroup;

    protected static ?string $recordTitleAttribute = 'name';

    protected static ?string $navigationLabel = 'Office Bearers';

    protected static string|UnitEnum|null $navigationGroup = 'Federation';

    protected static ?int $navigationSort = 10;

    public static function form(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make('Office bearer')
                    ->columns(2)
                    ->schema([
                        TextInput::make('name')
                            ->required()
                            ->maxLength(255),
                        TextInput::make('designation')
                            ->required()
                            ->maxLength(255)
                            ->placeholder('President, Secretary General, Treasurer...'),
                        Select::make('level')
                            ->options(BearerLevel::class)
                            ->default(BearerLevel::National)
                            ->required()
                            ->live(),
                        Select::make('state_association_id')
                            ->label('State association')
                            ->relationship('stateAssociation', 'name')
                            ->searchable()
                            ->preload()
                            ->visible(fn (Get $get): bool => self::isState($get('level')))
                            ->required(fn (Get $get): bool => self::isState($get('level'))),
                        TextInput::make('location')
                            ->maxLength(255)
                            ->placeholder('Pune, Maharashtra')
                            ->helperText('Optional. Shown under the name.'),
                        TextInput::make('sort_order')
                            ->label('Display order')
                            ->numeric()
                            ->minValue(0)
                            ->default(0)
                            ->helperText('Lower numbers appear first.'),
                    ]),
                Section::make('Photo')
                    ->schema([
                        FileUpload::make('photo')
                            ->hiddenLabel()
                            ->image()
                            ->imageEditor()
                            ->imageEditorAspectRatioOptions(['5:6'])
                            ->disk('public')
                            ->directory('office-bearers')
                            ->visibility('public')
                            ->maxSize(2048)
                            ->helperText('Portrait photo, JPG/PNG/WebP up to 2 MB. Cropped to 5:6 on the website.'),
                    ]),
                Toggle::make('is_published')
                    ->label('Show on website')
                    ->default(true),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->recordTitleAttribute('name')
            ->modifyQueryUsing(fn (Builder $query) => $query->with('stateAssociation'))
            ->defaultSort('sort_order')
            ->reorderable('sort_order')
            ->columns([
                ImageColumn::make('photo')
                    ->disk('public')
                    ->square()
                    ->defaultImageUrl(asset('assets/images/jfi/person-placeholder.svg')),
                TextColumn::make('name')
                    ->searchable()
                    ->description(fn (OfficeBearer $record): ?string => $record->location),
                TextColumn::make('designation')
                    ->searchable(),
                TextColumn::make('level')
                    ->badge(),
                TextColumn::make('stateAssociation.name')
                    ->label('State association')
                    ->placeholder('National')
                    ->toggleable(),
                ToggleColumn::make('is_published')
                    ->label('On website'),
            ])
            ->filters([
                SelectFilter::make('level')
                    ->options(BearerLevel::class),
            ])
            ->recordActions([
                EditAction::make(),
                DeleteAction::make(),
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                ]),
            ]);
    }

    public static function getPages(): array
    {
        return [
            'index' => ListOfficeBearers::route('/'),
            'create' => CreateOfficeBearer::route('/create'),
            'edit' => EditOfficeBearer::route('/{record}/edit'),
        ];
    }

    private static function isState(mixed $level): bool
    {
        return ($level instanceof BearerLevel ? $level : BearerLevel::tryFrom((string) $level)) === BearerLevel::State;
    }
}
