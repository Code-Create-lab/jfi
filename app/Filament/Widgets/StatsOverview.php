<?php

namespace App\Filament\Widgets;

use App\Enums\RegistrationStatus;
use App\Models\ContactMessage;
use App\Models\Event;
use App\Models\Player;
use App\Models\StateAssociation;
use Filament\Widgets\StatsOverviewWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;
use Illuminate\Support\Str;

class StatsOverview extends StatsOverviewWidget
{
    protected static ?int $sort = 1;

    protected ?string $pollingInterval = null;

    /**
     * @return array<Stat>
     */
    protected function getStats(): array
    {
        $pendingPlayers = Player::query()->where('status', RegistrationStatus::Pending)->count();
        $pendingAssociations = StateAssociation::query()->where('status', RegistrationStatus::Pending)->count();

        return [
            Stat::make('Registered players', number_format(Player::query()->count()))
                ->description($pendingPlayers.' pending review')
                ->descriptionIcon('heroicon-m-clock')
                ->color($pendingPlayers > 0 ? 'warning' : 'success'),
            Stat::make('State associations', number_format(StateAssociation::query()->where('status', RegistrationStatus::Approved)->count()))
                ->description($pendingAssociations.' '.Str::plural('application', $pendingAssociations).' pending')
                ->descriptionIcon('heroicon-m-clock')
                ->color($pendingAssociations > 0 ? 'warning' : 'success'),
            Stat::make('Upcoming events', number_format(Event::query()->upcoming()->count()))
                ->description(Event::query()->current()->count().' in progress')
                ->descriptionIcon('heroicon-m-calendar-days')
                ->color('primary'),
            Stat::make('Unread messages', number_format(ContactMessage::query()->whereNull('read_at')->count()))
                ->description('From the contact form')
                ->descriptionIcon('heroicon-m-envelope')
                ->color('gray'),
        ];
    }
}
