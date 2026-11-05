<?php

namespace App\Filament\Resources\Certificates\Schemas;

use App\Enums\RegistrationStatus;
use App\Models\Event;
use App\Models\Player;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Components\Component;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;

class CertificateForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make()
                    ->columns(2)
                    ->schema([
                        Select::make('player_id')
                            ->label('Player')
                            ->relationship(
                                'player',
                                'name',
                                fn (Builder $query, ?Model $record) => $query->where(
                                    fn (Builder $query) => $query
                                        ->where('status', RegistrationStatus::Approved)
                                        ->when($record?->getAttribute('player_id'), fn (Builder $query, int $id) => $query->orWhereKey($id)),
                                ),
                            )
                            ->getOptionLabelFromRecordUsing(fn (Player $record): string => $record->name.' ('.$record->registration_no.')')
                            ->searchable(['name', 'registration_no'])
                            ->required()
                            ->disabledOn('edit')
                            ->helperText('Only approved players are listed. Search by name or Player ID.')
                            ->columnSpanFull(),
                        ...static::certificateFields(),
                    ]),
            ]);
    }

    /**
     * The printed details, shared with the "Issue certificate" action on the
     * player page. Lengths keep the text on one line of the A4 template.
     *
     * @return array<Component>
     */
    public static function certificateFields(): array
    {
        return [
            TextInput::make('title')
                ->required()
                ->maxLength(40)
                ->default('Certificate of Participation')
                ->helperText('Printed in large capitals, up to 40 characters.'),
            TextInput::make('achievement')
                ->maxLength(80)
                ->placeholder('Winner, Junior Boys')
                ->helperText('Optional. Printed as "awarded this certificate for ...".'),
            // Plain options rather than a relationship: these fields also run on a Player record.
            Select::make('event_id')
                ->label('Event')
                ->options(fn (): array => Event::query()->orderByDesc('start_date')->pluck('title', 'id')->all())
                ->searchable()
                ->helperText('Optional. Printed with the event dates and city.'),
            DatePicker::make('issued_on')
                ->label('Issue date')
                ->required()
                ->native(false)
                ->displayFormat('d M Y')
                ->default(today()),
        ];
    }
}
