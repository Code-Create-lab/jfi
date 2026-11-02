<?php

namespace App\Filament\Resources\Players\Schemas;

use App\Enums\Gender;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Repeater;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;

class PlayerForm
{
    public static function configure(Schema $schema): Schema
    {
        $states = collect(config('jumpball.states'))->mapWithKeys(fn (string $state): array => [$state => $state])->all();

        return $schema
            ->columns(3)
            ->components([
                Section::make('Personal details')
                    ->columns(2)
                    ->columnSpan(2)
                    ->schema([
                        TextInput::make('name')
                            ->required()
                            ->maxLength(255),
                        TextInput::make('father_name')
                            ->label("Father's / guardian's name")
                            ->maxLength(255),
                        DatePicker::make('date_of_birth')
                            ->required()
                            ->native(false)
                            ->displayFormat('d M Y')
                            ->maxDate(now()),
                        Select::make('gender')
                            ->options(Gender::class)
                            ->required(),
                        TextInput::make('email')
                            ->email()
                            ->required()
                            ->maxLength(255)
                            ->unique(ignoreRecord: true),
                        TextInput::make('phone')
                            ->tel()
                            ->required()
                            ->maxLength(15)
                            ->regex('/^\+?[0-9 ]{10,15}$/')
                            ->validationMessages(['regex' => 'Enter a valid phone number (10 to 15 digits).']),
                    ]),
                Section::make('Photo')
                    ->columnSpan(1)
                    ->schema([
                        FileUpload::make('photo')
                            ->hiddenLabel()
                            ->image()
                            ->imageEditor()
                            ->disk('local')
                            ->directory('player-photos')
                            ->visibility('private')
                            ->maxSize(2048)
                            ->helperText('JPG, PNG or WebP up to 2 MB. Kept private.'),
                    ]),
                Section::make('Address')
                    ->columns(2)
                    ->columnSpan(2)
                    ->schema([
                        Textarea::make('address')
                            ->rows(2)
                            ->columnSpanFull(),
                        TextInput::make('city')
                            ->maxLength(255),
                        Select::make('state')
                            ->options($states)
                            ->searchable(),
                        TextInput::make('pincode')
                            ->maxLength(6)
                            ->regex('/^[1-9][0-9]{5}$/')
                            ->validationMessages(['regex' => 'Enter a 6-digit PIN code.']),
                    ]),
                Section::make('Association & login')
                    ->columnSpan(1)
                    ->schema([
                        Select::make('state_association_id')
                            ->label('State association')
                            ->relationship('stateAssociation', 'name')
                            ->searchable()
                            ->preload(),
                        TextInput::make('password')
                            ->label(fn (string $operation): string => $operation === 'create' ? 'Password' : 'New password')
                            ->password()
                            ->revealable()
                            ->minLength(8)
                            ->maxLength(255)
                            ->required(fn (string $operation): bool => $operation === 'create')
                            ->dehydrated(fn (?string $state): bool => filled($state))
                            ->helperText(fn (string $operation): ?string => $operation === 'edit' ? 'Leave blank to keep the current password.' : 'Used by the player to sign in.'),
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
                                    ->options(config('jumpball.player_document_types'))
                                    ->required(),
                                FileUpload::make('file_path')
                                    ->label('File')
                                    ->required()
                                    ->disk('local')
                                    ->directory('registration-documents/players')
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
