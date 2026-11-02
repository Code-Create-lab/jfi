<?php

namespace App\Filament\Resources\Galleries\RelationManagers;

use Filament\Actions\Action;
use Filament\Actions\DeleteAction;
use Filament\Actions\DeleteBulkAction;
use Filament\Forms\Components\FileUpload;
use Filament\Notifications\Notification;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Columns\ImageColumn;
use Filament\Tables\Columns\TextInputColumn;
use Filament\Tables\Table;

class ImagesRelationManager extends RelationManager
{
    protected static string $relationship = 'images';

    protected static ?string $title = 'Photos';

    /**
     * Phone photos are resized in the browser before upload (about 1600 px
     * wide), so uploads are fast and no server-side image package is needed.
     */
    public const int MAX_PHOTOS_PER_BATCH = 20;

    public function table(Table $table): Table
    {
        return $table
            ->recordTitleAttribute('caption')
            ->reorderable('sort_order')
            ->defaultSort('sort_order')
            ->paginated([24, 48, 96])
            ->columns([
                ImageColumn::make('image')
                    ->disk('public')
                    ->imageHeight(72),
                TextInputColumn::make('caption')
                    ->placeholder('Add a caption')
                    ->rules(['nullable', 'string', 'max:255']),
            ])
            ->headerActions([
                Action::make('upload')
                    ->label('Upload photos')
                    ->icon(Heroicon::OutlinedArrowUpTray)
                    ->modalSubmitActionLabel('Add to album')
                    ->schema([
                        FileUpload::make('photos')
                            ->hiddenLabel()
                            ->multiple()
                            ->maxFiles(self::MAX_PHOTOS_PER_BATCH)
                            ->required()
                            ->image()
                            ->disk('public')
                            ->directory('gallery')
                            ->visibility('public')
                            ->maxSize(8192)
                            ->imageResizeTargetWidth('1600')
                            ->imageResizeMode('contain')
                            ->imageResizeUpscale(false)
                            ->panelLayout('grid')
                            ->helperText('Up to '.self::MAX_PHOTOS_PER_BATCH.' photos at a time, JPG, PNG or WebP. Large photos are resized to about 1600 px wide before upload.'),
                    ])
                    ->action(function (array $data): void {
                        $gallery = $this->getOwnerRecord();
                        $order = (int) $gallery->images()->max('sort_order');

                        foreach ($data['photos'] as $path) {
                            $gallery->images()->create(['image' => $path, 'sort_order' => ++$order]);
                        }

                        Notification::make()->success()->title(count($data['photos']).' photos added')->send();
                    }),
            ])
            ->recordActions([
                DeleteAction::make(),
            ])
            ->toolbarActions([
                DeleteBulkAction::make(),
            ])
            ->emptyStateHeading('No photos yet')
            ->emptyStateDescription('Use "Upload photos" to add pictures to this album.');
    }
}
