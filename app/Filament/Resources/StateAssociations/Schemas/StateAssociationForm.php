<?php

namespace App\Filament\Resources\StateAssociations\Schemas;

use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Repeater;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;

class StateAssociationForm
{
    public static function configure(Schema $schema): Schema
    {
        $states = collect(config('jumpball.states'))->mapWithKeys(fn (string $state): array => [$state => $state])->all();

        return $schema
            ->columns(3)
            ->components([
                Section::make('Association details')
                    ->columns(2)
                    ->columnSpan(2)
                    ->schema([
                        TextInput::make('name')
                            ->label('Association name')
                            ->required()
                            ->maxLength(255)
                            ->columnSpanFull(),
                        Select::make('state')
                            ->options($states)
                            ->searchable()
                            ->required(),
                        TextInput::make('society_registration_no')
                            ->label('Society registration no.')
                            ->maxLength(255),
                        TextInput::make('email')
                            ->email()
                            ->required()
                            ->maxLength(255)
                            ->helperText('Approval and rejection emails go to this address.'),
                        TextInput::make('phone')
                            ->tel()
                            ->required()
                            ->maxLength(15)
                            ->regex('/^\+?[0-9 ]{10,15}$/')
                            ->validationMessages(['regex' => 'Enter a valid phone number (10 to 15 digits).']),
                    ]),
                Section::make('Logo')
                    ->columnSpan(1)
                    ->schema([
                        FileUpload::make('logo')
                            ->hiddenLabel()
                            ->image()
                            ->imageEditor()
                            ->disk('public')
                            ->directory('association-logos')
                            ->visibility('public')
                            ->maxSize(2048)
                            ->helperText('JPG, PNG or WebP up to 2 MB. Shown on the public list once approved.'),
                    ]),
                Section::make('Office holders & address')
                    ->columns(2)
                    ->columnSpanFull()
                    ->schema([
                        TextInput::make('president_name')
                            ->label('President')
                            ->maxLength(255),
                        TextInput::make('secretary_name')
                            ->label('Secretary')
                            ->maxLength(255),
                        Textarea::make('address')
                            ->rows(2)
                            ->columnSpanFull(),
                        TextInput::make('city')
                            ->maxLength(255),
                        TextInput::make('pincode')
                            ->label('PIN code')
                            ->maxLength(6)
                            ->regex('/^[1-9][0-9]{5}$/')
                            ->validationMessages(['regex' => 'Enter a 6-digit PIN code.']),
                    ]),
                Section::make('Documents')
                    ->columnSpanFull()
                    ->schema([
                        Repeater::make('documents')
                            ->hiddenLabel()
                            ->relationship()
                            ->columns(2)
                            ->defaultItems(0)
                            ->addActionLabel('Add document')
                            ->schema([
                                Select::make('document_type')
                                    ->options(config('jumpball.association_document_types'))
                                    ->required(),
                                FileUpload::make('file_path')
                                    ->label('File')
                                    ->required()
                                    ->disk('local')
                                    ->directory('registration-documents/associations')
                                    ->visibility('private')
                                    ->acceptedFileTypes(['application/pdf', 'image/jpeg', 'image/png', 'image/webp'])
                                    ->maxSize(5120)
                                    ->storeFileNamesIn('original_name')
                                    ->helperText('PDF, JPG or PNG up to 5 MB. Kept private.'),
                            ]),
                    ]),
            ]);
    }
}
