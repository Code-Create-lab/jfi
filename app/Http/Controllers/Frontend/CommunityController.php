<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\CommunityCategory;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\View\View;

/**
 * Community & Awareness: information only (CLAUDE.md section 6). Only
 * published categories and posts are shown.
 */
class CommunityController extends Controller
{
    public function index(): View
    {
        return view('frontend.community.index', [
            'categories' => CommunityCategory::query()
                ->published()
                ->withCount(['posts' => fn (Builder $query) => $query->published()])
                ->orderBy('sort_order')
                ->orderBy('name')
                ->get(),
        ]);
    }

    public function show(string $slug): View
    {
        return view('frontend.community.show', [
            'category' => CommunityCategory::query()
                ->published()
                ->where('slug', $slug)
                ->with(['posts' => fn (HasMany $query) => $query->published()->orderBy('sort_order')->orderBy('id')])
                ->firstOrFail(),
            'categories' => CommunityCategory::query()->published()->orderBy('sort_order')->orderBy('name')->get(['id', 'name', 'slug']),
        ]);
    }
}
