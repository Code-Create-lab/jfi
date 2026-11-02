<?php

namespace App\Filament\Resources\Galleries;

use App\Filament\Resources\Galleries\Pages\CreateGallery;
use App\Filament\Resources\Galleries\Pages\EditGallery;
use App\Filament\Resources\Galleries\Pages\ListGalleries;
use App\Filament\Resources\Galleries\RelationManagers\ImagesRelationManager;
use App\Models\Gallery;
use App\Models\GalleryImage;
use BackedEnum;
use Filament\Actions\DeleteAction;
use Filament\Actions\EditAction;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Select;
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
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use UnitEnum;

class GalleryResource extends Resource
{
    protected static ?string $model = Gallery::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedPhoto;

    protected static string|UnitEnum|null $navigationGroup = 'Events & Media';

    protected static ?int $navigationSort = 2;

    protected static ?string $navigationLabel = 'Photo Galleries';

    protected static ?string $modelLabel = 'gallery';

    protected static ?string $pluralModelLabel = 'galleries';

    protected static ?string $recordTitleAttribute = 'title';

    public static function form(Schema $schema): Schema
    {
        return $schema
            ->columns(3)
            ->components([
                Section::make('Album')
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
                            ->helperText('Leave blank to create it from the title.'),
                        Select::make('event_id')
                            ->label('Event (optional)')
                            ->relationship('event', 'title')
                            ->searchable()
                            ->preload(),
                        Toggle::make('is_published')
                            ->label('Show on website')
                            ->default(true),
                    ]),
                Section::make('Cover')
                    ->columnSpan(1)
                    ->schema([
                        FileUpload::make('cover_image')
                            ->hiddenLabel()
                            ->image()
                            ->disk('public')
                            ->directory('galleries')
                            ->visibility('public')
                            ->maxSize(4096)
                            ->imageResizeTargetWidth('1600')
                            ->imageResizeMode('contain')
                            ->imageResizeUpscale(false)
                            ->helperText('Optional. The first photo is used when empty.'),
                    ]),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->modifyQueryUsing(fn (Builder $query) => $query
                ->with('event')
                ->withCount('images')
                ->addSelect(['first_image' => GalleryImage::query()
                    ->select('image')
                    ->whereColumn('gallery_id', 'galleries.id')
                    ->orderBy('sort_order')
                    ->orderBy('id')
                    ->limit(1)]))
            ->defaultSort('created_at', 'desc')
            ->columns([
                ImageColumn::make('cover_image')
                    ->label('Cover')
                    ->disk('public')
                    ->state(fn (Gallery $record): ?string => $record->cover_image ?: $record->getAttribute('first_image'))
                    ->defaultImageUrl(asset('assets/images/jfi/cover-4.webp')),
                TextColumn::make('title')
                    ->searchable()
                    ->sortable()
                    ->wrap()
                    ->weight('medium'),
                TextColumn::make('event.title')
                    ->label('Event')
                    ->placeholder('-')
                    ->wrap(),
                TextColumn::make('images_count')
                    ->label('Photos')
                    ->alignCenter(),
                ToggleColumn::make('is_published')
                    ->label('On website'),
            ])
            ->filters([
                SelectFilter::make('event_id')
                    ->label('Event')
                    ->relationship('event', 'title')
                    ->searchable()
                    ->preload(),
            ])
            ->recordActions([
                EditAction::make()->label('Photos'),
                DeleteAction::make()
                    ->modalDescription('This deletes the album and all its photos.'),
            ])
            ->emptyStateHeading('No galleries yet');
    }

    public static function getRelations(): array
    {
        return [
            ImagesRelationManager::class,
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => ListGalleries::route('/'),
            'create' => CreateGallery::route('/create'),
            'edit' => EditGallery::route('/{record}/edit'),
        ];
    }
}
