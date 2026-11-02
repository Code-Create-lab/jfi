<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Event;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\View\View;

class EventController extends Controller
{
    /**
     * Current, upcoming or previous events, worked out from the dates.
     */
    public function index(string $period): View
    {
        $query = Event::query()->published();

        match ($period) {
            'current' => $query->current(),
            'upcoming' => $query->upcoming(),
            default => $query->previous(),
        };

        $events = $query
            ->orderBy('start_date', $period === 'previous' ? 'desc' : 'asc')
            ->orderBy('id')
            ->paginate(12);

        return view('frontend.events.index', [
            'period' => $period,
            'events' => $events,
        ]);
    }

    public function show(string $slug): View
    {
        $event = Event::query()
            ->published()
            ->where('slug', $slug)
            ->with(['results' => fn (HasMany $query) => $query->orderBy('category')->orderBy('position')->with('stateAssociation')])
            ->firstOrFail();

        return view('frontend.events.show', [
            'event' => $event,
            'galleries' => $event->galleries()
                ->published()
                ->whereHas('images')
                ->with(['images' => fn (HasMany $query) => $query->orderBy('sort_order')->orderBy('id')])
                ->latest()
                ->get(),
            'videos' => $event->videos()->published()->orderBy('sort_order')->get(),
        ]);
    }

    /**
     * Championship results. Position 0 lists every event with results; 1-3
     * list that placing in every category (Winners, Runners-up, Third place).
     */
    public function results(int $position): View
    {
        $results = fn (HasMany $query) => $query
            ->when($position > 0, fn (Builder $query) => $query->where('position', $position))
            ->orderBy('category')
            ->orderBy('position')
            ->with('stateAssociation');

        $events = Event::query()
            ->published()
            ->whereHas('results', fn (Builder $query) => $query->when($position > 0, fn (Builder $query) => $query->where('position', $position)))
            ->with(['results' => $results])
            ->orderByDesc('start_date')
            ->paginate($position > 0 ? 30 : 10);

        return view('frontend.results.index', [
            'position' => $position,
            'events' => $events,
        ]);
    }
}
