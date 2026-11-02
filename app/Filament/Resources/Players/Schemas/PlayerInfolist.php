<?php

namespace App\Filament\Resources\Players\Schemas;

use App\Models\RegistrationDocument;
use Filament\Infolists\Components\ImageEntry;
use Filament\Infolists\Components\RepeatableEntry;
use Filament\Infolists\Components\TextEntry;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;

class PlayerInfolist
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->columns(3)
            ->components([
                Section::make('Registration')
                    ->columns(2)
                    ->columnSpan(2)
                    ->schema([
                        TextEntry::make('registration_no')
                            ->label('Player ID')
                            ->weight('bold')
                            ->copyable(),
                        TextEntry::make('status')
                            ->badge(),
                        TextEntry::make('created_at')
                            ->label('Registered on')
                            ->dateTime('d M Y, h:i A'),
                        TextEntry::make('reviewed_at')
                            ->label('Reviewed on')
                            ->dateTime('d M Y, h:i A')
                            ->placeholder('Not reviewed yet'),
                        TextEntry::make('admin_remarks')
                            ->label('Remarks')
                            ->placeholder('None')
                            ->columnSpanFull(),
                    ]),
                Section::make('Photo')
                    ->columnSpan(1)
                    ->schema([
                        ImageEntry::make('photo')
                            ->hiddenLabel()
                            ->disk('local')
                            ->visibility('private')
                            ->imageHeight(220)
                            ->placeholder('No photo uploaded'),
                    ]),
                Section::make('Personal details')
                    ->columns(3)
                    ->columnSpanFull()
                    ->schema([
                        TextEntry::make('name'),
                        TextEntry::make('father_name')->label("Father's / guardian's name")->placeholder('-'),
                        TextEntry::make('date_of_birth')->date('d M Y'),
                        TextEntry::make('gender'),
                        TextEntry::make('email')->copyable(),
                        TextEntry::make('phone')->copyable(),
                    ]),
                Section::make('Address & association')
                    ->columns(3)
                    ->columnSpanFull()
                    ->schema([
                        TextEntry::make('address')->placeholder('-')->columnSpanFull(),
                        TextEntry::make('city')->placeholder('-'),
                        TextEntry::make('state')->placeholder('-'),
                        TextEntry::make('pincode')->label('PIN code')->placeholder('-'),
                        TextEntry::make('stateAssociation.name')->label('State association')->placeholder('Not linked')->columnSpanFull(),
                    ]),
                Section::make('Documents')
                    ->columnSpanFull()
                    ->schema([
                        RepeatableEntry::make('documents')
                            ->hiddenLabel()
                            ->columns(2)
                            ->placeholder('No documents uploaded')
                            ->schema([
                                TextEntry::make('document_type')
                                    ->label('Type')
                                    ->formatStateUsing(fn (string $state): string => config('jumpball.player_document_types.'.$state, $state)),
                                TextEntry::make('original_name')
                                    ->label('File')
                                    ->default('Download')
                                    ->icon('heroicon-m-arrow-down-tray')
                                    ->color('primary')
                                    ->url(fn (RegistrationDocument $record): string => route('filament.admin.registration-documents.download', $record)),
                            ]),
                    ]),
            ]);
    }
}
