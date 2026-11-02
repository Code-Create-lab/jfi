<?php

namespace App\Filament\Widgets;

use App\Enums\RegistrationStatus;
use App\Filament\Resources\ContactMessages\ContactMessageResource;
use App\Filament\Resources\Events\EventResource;
use App\Filament\Resources\Players\PlayerResource;
use App\Filament\Resources\StateAssociations\StateAssociationResource;
use App\Models\ContactMessage;
use App\Models\Event;
use App\Models\Player;
use App\Models\StateAssociation;
use Filament\Widgets\StatsOverviewWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;

class StatsOverview extends StatsOverviewWidget
{
    protected static ?int $sort = 1;

    protected ?string $pollingInterval = null;

    protected function getColumns(): int
    {
        return 5;
    }

    /**
     * @return array<Stat>
     */
    protected function getStats(): array
    {
        $players = Player::query()
            ->selectRaw('status, count(*) as aggregate')
            ->groupBy('status')
            ->pluck('aggregate', 'status');

        $pendingPlayers = (int) ($players[RegistrationStatus::Pending->value] ?? 0);
        $pendingAssociations = StateAssociation::query()->where('status', RegistrationStatus::Pending)->count();
        $unread = ContactMessage::query()->whereNull('read_at')->count();

        return [
            Stat::make('Pending players', number_format($pendingPlayers))
                ->description('Waiting for review')
                ->descriptionIcon('heroicon-m-clock')
                ->color($pendingPlayers > 0 ? 'warning' : 'gray')
                ->url(PlayerResource::getUrl('index', ['tab' => 'pending'])),
            Stat::make('Approved players', number_format((int) ($players[RegistrationStatus::Approved->value] ?? 0)))
                ->description('In the Player Database')
                ->descriptionIcon('heroicon-m-check-badge')
                ->color('success')
                ->url(PlayerResource::getUrl('index', ['tab' => 'approved'])),
            Stat::make('Pending associations', number_format($pendingAssociations))
                ->description('Applications to review')
                ->descriptionIcon('heroicon-m-clock')
                ->color($pendingAssociations > 0 ? 'warning' : 'gray')
                ->url(StateAssociationResource::getUrl('index', ['tab' => 'pending'])),
            Stat::make('Upcoming events', number_format(Event::query()->upcoming()->count()))
                ->description(Event::query()->current()->count().' in progress')
                ->descriptionIcon('heroicon-m-calendar-days')
                ->color('primary')
                ->url(EventResource::getUrl('index')),
            Stat::make('Unread messages', number_format($unread))
                ->description('From the contact form')
                ->descriptionIcon('heroicon-m-envelope')
                ->color($unread > 0 ? 'info' : 'gray')
                ->url(ContactMessageResource::getUrl('index')),
        ];
    }
}
