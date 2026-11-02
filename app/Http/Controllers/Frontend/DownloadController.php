<?php

namespace App\Http\Controllers\Frontend;

use App\Enums\DownloadCategory;
use App\Http\Controllers\Controller;
use App\Models\Download;
use Illuminate\Http\Request;
use Illuminate\View\View;

/**
 * Downloads & Official Notices, and the Rule Book page (the rule_book
 * category; the newest file is shown as the current edition).
 */
class DownloadController extends Controller
{
    public function index(Request $request, string $mode = 'downloads'): View
    {
        $category = $mode === 'rule-book'
            ? DownloadCategory::RuleBook
            : DownloadCategory::tryFrom((string) $request->query('category'));

        return view('frontend.downloads', [
            'mode' => $mode,
            'downloads' => Download::query()
                ->published()
                ->when($category, fn ($query) => $query->where('category', $category))
                ->orderByDesc('published_on')
                ->orderByDesc('id')
                ->get(),
        ]);
    }
}
