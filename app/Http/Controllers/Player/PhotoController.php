<?php

namespace App\Http\Controllers\Player;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Symfony\Component\HttpFoundation\StreamedResponse;

/**
 * Player photos are on the private disk; this shows the signed-in player
 * their own photo on the dashboard.
 */
class PhotoController extends Controller
{
    public function __invoke(Request $request): StreamedResponse
    {
        $photo = $request->user('player')->photo;

        abort_unless($photo && Storage::disk('local')->exists($photo), 404);

        return Storage::disk('local')->response($photo, headers: ['Cache-Control' => 'private, max-age=3600']);
    }
}
