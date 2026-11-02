<?php

namespace App\Filament\Resources\StateAssociations\Schemas;

use App\Models\RegistrationDocument;
use Filament\Infolists\Components\ImageEntry;
use Filament\Infolists\Components\RepeatableEntry;
use Filament\Infolists\Components\TextEntry;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;

class StateAssociationInfolist
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->columns(3)
            ->components([
                Section::make('Application')
                    ->columns(2)
                    ->columnSpan(2)
                    ->schema([
                        TextEntry::make('status')
                            ->badge(),
                        TextEntry::make('created_at')
                            ->label('Submitted on')
                            ->dateTime('d M Y, h:i A'),
                        TextEntry::make('reviewed_at')
                            ->label('Reviewed on')
                            ->dateTime('d M Y, h:i A')
                            ->placeholder('Not reviewed yet'),
                        TextEntry::make('terms_accepted_at')
                            ->label('Terms accepted')
                            ->dateTime('d M Y, h:i A')
                            ->placeholder('-'),
                        TextEntry::make('admin_remarks')
                            ->label('Remarks')
                            ->placeholder('None')
                            ->columnSpanFull(),
                    ]),
                Section::make('Logo')
                    ->columnSpan(1)
                    ->schema([
                        ImageEntry::make('logo')
                            ->hiddenLabel()
                            ->disk('public')
                            ->imageHeight(140)
                            ->placeholder('No logo uploaded'),
                    ]),
                Section::make('Association details')
                    ->columns(3)
                    ->columnSpanFull()
                    ->schema([
                        TextEntry::make('name')->columnSpan(2),
                        TextEntry::make('state'),
                        TextEntry::make('email')->copyable(),
                        TextEntry::make('phone')->copyable(),
                        TextEntry::make('society_registration_no')->label('Society registration no.')->placeholder('-'),
                        TextEntry::make('president_name')->label('President')->placeholder('-'),
                        TextEntry::make('secretary_name')->label('Secretary')->placeholder('-'),
                        TextEntry::make('city')->placeholder('-'),
                        TextEntry::make('address')->placeholder('-')->columnSpan(2),
                        TextEntry::make('pincode')->label('PIN code')->placeholder('-'),
                    ]),
                Section::make('Linked records')
                    ->columns(2)
                    ->columnSpanFull()
                    ->schema([
                        TextEntry::make('players_count')
                            ->label('Players')
                            ->state(fn ($record): int => $record->players()->count()),
                        TextEntry::make('office_bearers_count')
                            ->label('State office bearers')
                            ->state(fn ($record): int => $record->officeBearers()->count()),
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
                                    ->formatStateUsing(fn (string $state): string => config('jumpball.association_document_types.'.$state, $state)),
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
