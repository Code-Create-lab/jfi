<?php

namespace App\Filament\Resources\CommunityCategories;

use App\Filament\Resources\CommunityCategories\Pages\CreateCommunityCategory;
use App\Filament\Resources\CommunityCategories\Pages\EditCommunityCategory;
use App\Filament\Resources\CommunityCategories\Pages\ListCommunityCategories;
use App\Filament\Resources\CommunityCategories\RelationManagers\PostsRelationManager;
use App\Filament\Support\Fields;
use App\Models\CommunityCategory;
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
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use UnitEnum;

/**
 * Community & Awareness (CLAUDE.md section 6): information only. No
 * complaint submission, case tracking or messaging is built here.
 */
class CommunityCategoryResource extends Resource
{
    protected static ?string $model = CommunityCategory::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedShieldCheck;

    protected static string|UnitEnum|null $navigationGroup = 'Content';

    protected static ?int $navigationSort = 5;

    protected static ?string $navigationLabel = 'Community & Awareness';

    protected static ?string $modelLabel = 'awareness category';

    protected static ?string $pluralModelLabel = 'awareness categories';

    protected static ?string $recordTitleAttribute = 'name';

    public static function form(Schema $schema): Schema
    {
        return $schema
            ->columns(3)
            ->components([
                Section::make('Category')
                    ->columns(2)
                    ->columnSpan(2)
                    ->schema([
                        TextInput::make('name')
                            ->required()
                            ->maxLength(255)
                            ->placeholder('Player Safety, Respectful Conduct...'),
                        TextInput::make('slug')
                            ->label('URL slug')
                            ->maxLength(255)
                            ->alphaDash()
                            ->unique(ignoreRecord: true)
                            ->helperText('Leave blank to create it from the name.'),
                        Textarea::make('short_description')
                            ->rows(2)
                            ->maxLength(500)
                            ->helperText('Shown on the Community overview cards.')
                            ->columnSpanFull(),
                        Fields::richText('description')
                            ->columnSpanFull(),
                        Textarea::make('support_contact')
                            ->label('Support contact')
                            ->rows(3)
                            ->maxLength(1000)
                            ->helperText('Who to contact for help with this topic (name, phone, email). Information only: the website does not take complaints.')
                            ->columnSpanFull(),
                    ]),
                Section::make('Image & visibility')
                    ->columnSpan(1)
                    ->schema([
                        FileUpload::make('image')
                            ->image()
                            ->imageEditor()
                            ->disk('public')
                            ->directory('community')
                            ->visibility('public')
                            ->maxSize(4096)
                            ->helperText('Optional. JPG, PNG or WebP up to 4 MB.'),
                        Toggle::make('is_published')
                            ->label('Published')
                            ->helperText('Only published categories and posts appear on the website.')
                            ->default(true),
                    ]),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->modifyQueryUsing(fn (Builder $query) => $query->withCount('posts'))
            ->reorderable('sort_order')
            ->defaultSort('sort_order')
            ->columns([
                ImageColumn::make('image')
                    ->disk('public')
                    ->defaultImageUrl(asset('assets/images/jfi/cover-6.webp')),
                TextColumn::make('name')
                    ->searchable()
                    ->weight('medium')
                    ->description(fn (CommunityCategory $record): ?string => $record->short_description),
                TextColumn::make('posts_count')
                    ->label('Posts')
                    ->alignCenter(),
                ToggleColumn::make('is_published')
                    ->label('Published'),
            ])
            ->recordActions([
                EditAction::make(),
                DeleteAction::make()
                    ->modalDescription('This deletes the category and all its posts, images and documents.'),
            ])
            ->emptyStateHeading('No awareness categories yet');
    }

    public static function getRelations(): array
    {
        return [
            PostsRelationManager::class,
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => ListCommunityCategories::route('/'),
            'create' => CreateCommunityCategory::route('/create'),
            'edit' => EditCommunityCategory::route('/{record}/edit'),
        ];
    }
}
