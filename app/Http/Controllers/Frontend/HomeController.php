<?php

namespace App\Http\Controllers\Frontend;

use App\Enums\NewsType;
use App\Enums\RegistrationStatus;
use App\Http\Controllers\Controller;
use App\Models\Banner;
use App\Models\Event;
use App\Models\Gallery;
use App\Models\InternationalPlayer;
use App\Models\News;
use App\Models\OfficeBearer;
use App\Models\Player;
use App\Models\StateAssociation;
use Illuminate\View\View;

class HomeController extends Controller
{
    public function __invoke(): View
    {
        $activeEvents = Event::query()->published()->notFinished();

        return view('frontend.home', [
            'banners' => Banner::query()->published()->orderBy('sort_order')->orderBy('id')->get(),
            'stats' => [
                'associations' => StateAssociation::query()->approved()->count(),
                'players' => Player::query()->where('status', RegistrationStatus::Approved)->count(),
                'championships' => Event::query()->published()->previous()->count(),
            ],
            // Earliest current or upcoming event, for the hero panel.
            'nextEvent' => (clone $activeEvents)->orderBy('start_date')->first(),
            // Featured first, then by date.
            'upcomingEvents' => (clone $activeEvents)->orderByDesc('is_featured')->orderBy('start_date')->limit(3)->get(),
            'announcements' => News::query()->published()->where('type', NewsType::Announcement)->latest('published_on')->latest('id')->limit(3)->get(),
            'latestNews' => News::query()->published()->latest('published_on')->latest('id')->limit(3)->get(),
            'galleries' => Gallery::query()
                ->published()
                ->whereHas('images')
                ->with(['images' => fn ($query) => $query->orderBy('sort_order')->orderBy('id')])
                ->latest()
                ->limit(1)
                ->get(),
            'internationalPlayers' => InternationalPlayer::query()->published()->orderBy('country')->orderBy('sort_order')->limit(8)->get(),
            'nationalBearers' => OfficeBearer::nationalForDisplay(),
        ]);
    }
}
