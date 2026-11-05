<?php

use App\Http\Middleware\EnsurePlayerApproved;
use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;
use Illuminate\Http\Request;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        commands: __DIR__.'/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware): void {
        $middleware->alias(['player.approved' => EnsurePlayerApproved::class]);

        // Signed-out visitors on player pages go to the player login; the
        // admin panel keeps redirecting to its own login page.
        $middleware->redirectGuestsTo(fn (): string => route('frontend.players.login'));
        $middleware->redirectUsersTo(fn (): string => route('player.dashboard'));
    })
    ->withExceptions(function (Exceptions $exceptions): void {
        $exceptions->shouldRenderJsonWhen(
            fn (Request $request) => $request->is('api/*') || $request->expectsJson(),
        );
    })->create();
