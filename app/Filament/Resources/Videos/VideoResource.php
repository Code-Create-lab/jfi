<?php

namespace App\Filament\Resources\Videos;

use App\Filament\Resources\Videos\Pages\CreateVideo;
use App\Filament\Resources\Videos\Pages\EditVideo;
use App\Filament\Resources\Videos\Pages\ListVideos;
use App\Models\Video;
use BackedEnum;
use Filament\Actions\Action;
use Filament\Actions\DeleteAction;
use Filament\Actions\EditAction;
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
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use UnitEnum;

class VideoResource extends Resource
{
    protected static ?string $model = Video::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedPlayCircle;

    protected static string|UnitEnum|null $navigationGroup = 'Events & Media';

    protected static ?int $navigationSort = 3;

    protected static ?string $recordTitleAttribute = 'title';

    public static function form(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make()
                    ->columns(2)
                    ->schema([
                        TextInput::make('title')
                            ->required()
                            ->maxLength(255)
                            ->columnSpanFull(),
                        TextInput::make('url')
                            ->label('Video link')
                            ->required()
                            ->url()
                            ->maxLength(500)
                            ->regex(Video::URL_PATTERN)
                            ->validationMessages(['regex' => 'Use a YouTube, Vimeo or Facebook video link.'])
                            ->placeholder('https://www.youtube.com/watch?v=...')
                            ->helperText('YouTube, Vimeo or Facebook. Paste the link from the browser address bar or the Share button.')
                            ->columnSpanFull(),
                        Select::make('event_id')
                            ->label('Event (optional)')
                            ->relationship('event', 'title')
                            ->searchable()
                            ->preload(),
                        Toggle::make('is_published')
                            ->label('Show on website')
                            ->default(true)
                            ->inline(false),
                    ]),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->modifyQueryUsing(fn (Builder $query) => $query->with('event'))
            ->reorderable('sort_order')
            ->defaultSort('sort_order')
            ->columns([
                ImageColumn::make('thumbnail')
                    ->state(fn (Video $record): ?string => $record->thumbnail_url)
                    ->defaultImageUrl(asset('assets/images/jfi/cover-5.webp'))
                    ->imageHeight(48),
                TextColumn::make('title')
                    ->searchable()
                    ->wrap()
                    ->weight('medium')
                    ->description(fn (Video $record): string => parse_url($record->url, PHP_URL_HOST) ?: $record->url),
                TextColumn::make('event.title')
                    ->label('Event')
                    ->placeholder('-')
                    ->wrap(),
                ToggleColumn::make('is_published')
                    ->label('On website'),
            ])
            ->recordActions([
                Action::make('watch')
                    ->icon(Heroicon::OutlinedArrowTopRightOnSquare)
                    ->color('gray')
                    ->url(fn (Video $record): string => $record->url)
                    ->openUrlInNewTab(),
                EditAction::make(),
                DeleteAction::make(),
            ])
            ->emptyStateHeading('No videos yet');
    }

    public static function getPages(): array
    {
        return [
            'index' => ListVideos::route('/'),
            'create' => CreateVideo::route('/create'),
            'edit' => EditVideo::route('/{record}/edit'),
        ];
    }
}
