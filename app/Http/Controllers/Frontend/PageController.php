<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Page;
use Illuminate\View\View;

/**
 * The five content pages seeded by PageSeeder; each route passes its slug.
 */
class PageController extends Controller
{
    public function __invoke(string $slug): View
    {
        return view('frontend.page', [
            'page' => Page::query()->published()->where('slug', $slug)->firstOrFail(),
        ]);
    }
}
