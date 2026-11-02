<?php

namespace App\Filament\Resources\CommunityCategories\RelationManagers;

use App\Filament\Support\Fields;
use App\Models\CommunityPost;
use Filament\Actions\CreateAction;
use Filament\Actions\DeleteAction;
use Filament\Actions\EditAction;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Schemas\Schema;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\ImageColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Columns\ToggleColumn;
use Filament\Tables\Table;

class PostsRelationManager extends RelationManager
{
    protected static string $relationship = 'posts';

    protected static ?string $title = 'Posts (guidelines, information, documents)';

    public function form(Schema $schema): Schema
    {
        return $schema
            ->columns(2)
            ->components([
                TextInput::make('title')
                    ->required()
                    ->maxLength(255),
                TextInput::make('slug')
                    ->label('URL slug')
                    ->maxLength(255)
                    ->alphaDash()
                    ->unique(CommunityPost::class, 'slug', ignoreRecord: true)
                    ->helperText('Leave blank to create it from the title.'),
                Fields::richText('content')
                    ->columnSpanFull(),
                FileUpload::make('image')
                    ->image()
                    ->disk('public')
                    ->directory('community')
                    ->visibility('public')
                    ->maxSize(4096)
                    ->helperText('Optional. JPG, PNG or WebP up to 4 MB.'),
                FileUpload::make('document_path')
                    ->label('Document (PDF)')
                    ->disk('public')
                    ->directory('community/documents')
                    ->visibility('public')
                    ->acceptedFileTypes(['application/pdf'])
                    ->maxSize(10240)
                    ->downloadable()
                    ->helperText('Optional guideline or policy PDF, up to 10 MB. Public: anyone can download it.'),
                Toggle::make('is_published')
                    ->label('Published')
                    ->default(true),
            ]);
    }

    public function table(Table $table): Table
    {
        return $table
            ->recordTitleAttribute('title')
            ->reorderable('sort_order')
            ->defaultSort('sort_order')
            ->columns([
                ImageColumn::make('image')
                    ->disk('public')
                    ->defaultImageUrl(asset('assets/images/jfi/cover-6.webp')),
                TextColumn::make('title')
                    ->searchable()
                    ->weight('medium')
                    ->wrap(),
                IconColumn::make('document_path')
                    ->label('PDF')
                    ->boolean()
                    ->state(fn (CommunityPost $record): bool => filled($record->document_path)),
                ToggleColumn::make('is_published')
                    ->label('Published'),
            ])
            ->headerActions([
                CreateAction::make()->label('Add post'),
            ])
            ->recordActions([
                EditAction::make(),
                DeleteAction::make(),
            ])
            ->emptyStateHeading('No posts yet');
    }
}
