<?php

namespace App\Filament\Resources\Banners;

use App\Filament\Resources\Banners\Pages\CreateBanner;
use App\Filament\Resources\Banners\Pages\EditBanner;
use App\Filament\Resources\Banners\Pages\ListBanners;
use App\Models\Banner;
use BackedEnum;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteAction;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Forms\Components\FileUpload;
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
use UnitEnum;

class BannerResource extends Resource
{
    protected static ?string $model = Banner::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedPhoto;

    protected static string|UnitEnum|null $navigationGroup = 'Content';

    protected static ?int $navigationSort = 3;

    protected static ?string $navigationLabel = 'Home Banners';

    protected static ?string $recordTitleAttribute = 'title';

    public static function form(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make()
                    ->columns(2)
                    ->schema([
                        FileUpload::make('image')
                            ->required()
                            ->image()
                            ->imageEditor()
                            ->disk('public')
                            ->directory('banners')
                            ->visibility('public')
                            ->maxSize(5120)
                            ->helperText('Shown whole at 16:9 beside the home page headline, with no text on top, so lettering designed into the image stays readable. Best at 1920 × 1080 px. JPG, PNG or WebP up to 5 MB.')
                            ->columnSpanFull(),
                        TextInput::make('title')
                            ->required()
                            ->maxLength(255)
                            ->helperText('Describes the image for screen readers and search engines. Not shown on the page.'),
                        TextInput::make('subtitle')
                            ->maxLength(255)
                            ->helperText('Internal note for the admin list. Not shown on the page.'),
                        TextInput::make('button_text')
                            ->maxLength(50)
                            ->helperText('Optional. Read out with the link for screen readers.'),
                        TextInput::make('button_url')
                            ->label('Button link')
                            ->maxLength(255)
                            ->placeholder('/players/register or https://...')
                            ->helperText('Optional. Makes the whole banner clickable.')
                            ->regex('#^(/|https?://)#')
                            ->validationMessages(['regex' => 'Start with / for a page on this site, or with https://.']),
                        Toggle::make('is_published')
                            ->label('Show on website')
                            ->default(true),
                    ]),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->reorderable('sort_order')
            ->defaultSort('sort_order')
            ->columns([
                ImageColumn::make('image')
                    ->disk('public')
                    ->imageHeight(56),
                TextColumn::make('title')
                    ->searchable()
                    ->wrap()
                    ->weight('medium')
                    ->description(fn (Banner $record): ?string => $record->subtitle),
                ToggleColumn::make('is_published')
                    ->label('On website'),
            ])
            ->recordActions([
                EditAction::make(),
                DeleteAction::make(),
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                ]),
            ])
            ->emptyStateHeading('No banners yet')
            ->emptyStateDescription('The home page uses the built-in photos until a banner is added.');
    }

    public static function getPages(): array
    {
        return [
            'index' => ListBanners::route('/'),
            'create' => CreateBanner::route('/create'),
            'edit' => EditBanner::route('/{record}/edit'),
        ];
    }
}
