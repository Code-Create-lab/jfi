<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Gallery;
use App\Models\GalleryImage;
use App\Models\Video;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\View\View;

/**
 * Photo gallery albums and the video gallery.
 */
class MediaController extends Controller
{
    public function galleries(): View
    {
        return view('frontend.gallery.index', [
            'galleries' => Gallery::query()
                ->published()
                ->with('event')
                ->withCount('images')
                ->addSelect(['first_image' => GalleryImage::query()
                    ->select('image')
                    ->whereColumn('gallery_id', 'galleries.id')
                    ->orderBy('sort_order')
                    ->orderBy('id')
                    ->limit(1)])
                ->latest()
                ->paginate(12),
        ]);
    }

    public function gallery(string $slug): View
    {
        return view('frontend.gallery.show', [
            'gallery' => Gallery::query()
                ->published()
                ->where('slug', $slug)
                ->with(['event', 'images' => fn (HasMany $query) => $query->orderBy('sort_order')->orderBy('id')])
                ->firstOrFail(),
        ]);
    }

    public function videos(): View
    {
        return view('frontend.videos', [
            'videos' => Video::query()->published()->with('event')->orderBy('sort_order')->orderBy('id')->paginate(12),
        ]);
    }
}
