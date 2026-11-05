<?php

namespace App\Http\Controllers\Player;

use App\Http\Controllers\Controller;
use App\Http\Requests\Player\LoginRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

/**
 * Sign-in for registered players on the "player" guard (email or Player ID).
 * Pending and rejected players can sign in too; their dashboard shows the status.
 */
class LoginController extends Controller
{
    public function create(): View
    {
        return view('frontend.players.login');
    }

    public function store(LoginRequest $request): RedirectResponse
    {
        if (! Auth::guard('player')->attempt($request->credentials(), $request->boolean('remember'))) {
            return back()
                ->withInput($request->only('login', 'remember'))
                ->withErrors(['login' => 'The details you entered do not match our records.']);
        }

        $request->session()->regenerate();

        return redirect()->intended(route('player.dashboard'));
    }

    public function destroy(Request $request): RedirectResponse
    {
        Auth::guard('player')->logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('frontend.players.login')->with('status', 'You have signed out.');
    }
}
