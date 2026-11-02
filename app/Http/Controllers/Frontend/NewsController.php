<?php

namespace App\Http\Controllers\Frontend;

use App\Enums\NewsType;
use App\Http\Controllers\Controller;
use App\Models\News;
use Illuminate\Http\Request;
use Illuminate\View\View;

class NewsController extends Controller
{
    public function index(Request $request): View
    {
        $type = NewsType::tryFrom((string) $request->query('type'));

        return view('frontend.news.index', [
            'news' => News::query()
                ->published()
                ->when($type, fn ($query) => $query->where('type', $type))
                ->latest('published_on')
                ->latest('id')
                ->paginate(9)
                ->withQueryString(),
        ]);
    }

    public function show(string $slug): View
    {
        $item = News::query()->published()->where('slug', $slug)->firstOrFail();

        return view('frontend.news.show', [
            'item' => $item,
            'recentNews' => News::query()
                ->published()
                ->whereKeyNot($item->getKey())
                ->latest('published_on')
                ->latest('id')
                ->limit(4)
                ->get(),
        ]);
    }
}
