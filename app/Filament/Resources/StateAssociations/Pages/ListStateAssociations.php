<?php

namespace App\Filament\Resources\StateAssociations\Pages;

use App\Enums\RegistrationStatus;
use App\Filament\Resources\StateAssociations\StateAssociationResource;
use App\Models\StateAssociation;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;
use Filament\Schemas\Components\Tabs\Tab;
use Illuminate\Database\Eloquent\Builder;

class ListStateAssociations extends ListRecords
{
    protected static string $resource = StateAssociationResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make()->label('Add association'),
        ];
    }

    /**
     * @return array<string, Tab>
     */
    public function getTabs(): array
    {
        $counts = StateAssociation::query()
            ->selectRaw('status, count(*) as aggregate')
            ->groupBy('status')
            ->pluck('aggregate', 'status');

        $tabs = ['all' => Tab::make('All')->badge($counts->sum())];

        foreach (RegistrationStatus::cases() as $status) {
            $tabs[$status->value] = Tab::make($status->label())
                ->badge($counts[$status->value] ?? 0)
                ->badgeColor($status->getColor())
                ->modifyQueryUsing(fn (Builder $query) => $query->where('status', $status));
        }

        return $tabs;
    }
}
