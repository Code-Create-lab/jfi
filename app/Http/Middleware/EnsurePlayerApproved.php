<?php

namespace App\Http\Middleware;

use App\Enums\RegistrationStatus;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

/**
 * Pending and rejected players can sign in and see their status, but
 * certificate downloads are for approved players only.
 */
class EnsurePlayerApproved
{
    public function handle(Request $request, Closure $next): Response
    {
        if ($request->user('player')?->status !== RegistrationStatus::Approved) {
            return redirect()
                ->route('player.dashboard')
                ->with('status', 'Certificates can be downloaded once your registration is approved.');
        }

        return $next($request);
    }
}
