<?php

namespace App\Http\Controllers\Player;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\View\View;

/**
 * The signed-in player's own record (read-only): status, details and
 * certificates. The player always comes from the "player" guard.
 */
class DashboardController extends Controller
{
    public function __invoke(Request $request): View
    {
        $player = $request->user('player')->load([
            'stateAssociation',
            'certificates' => fn ($query) => $query->with('event')->latest('issued_on')->latest('id'),
        ]);

        return view('player.dashboard', ['player' => $player]);
    }
}
