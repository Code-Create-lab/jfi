<?php

namespace App\Http\Controllers\Player;

use App\Http\Controllers\Controller;
use App\Http\Requests\Player\ForgotPasswordRequest;
use App\Http\Requests\Player\ResetPasswordRequest;
use App\Models\Player;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Password;
use Illuminate\Support\Str;
use Illuminate\View\View;
use Throwable;

/**
 * Forgot / reset password for players through the "players" broker. The
 * link request always gets the same answer, so it cannot be used to find
 * out which email addresses are registered.
 */
class PasswordController extends Controller
{
    public function request(): View
    {
        return view('player.forgot-password');
    }

    public function email(ForgotPasswordRequest $request): RedirectResponse
    {
        try {
            Password::broker('players')->sendResetLink($request->only('email'));
        } catch (Throwable $exception) {
            report($exception);

            return back()
                ->withInput()
                ->withErrors(['email' => 'We could not send the email just now. Please try again later or contact the federation office.']);
        }

        return back()->with('status', 'If this email belongs to a registered player, a link to reset the password is on its way. The link works for '.config('auth.passwords.players.expire').' minutes.');
    }

    public function reset(Request $request, string $token): View
    {
        return view('player.reset-password', [
            'token' => $token,
            'email' => $request->string('email')->toString(),
        ]);
    }

    public function update(ResetPasswordRequest $request): RedirectResponse
    {
        $status = Password::broker('players')->reset(
            $request->only('email', 'password', 'password_confirmation', 'token'),
            function (Player $player, string $password): void {
                $player->forceFill(['password' => $password])->setRememberToken(Str::random(60));
                $player->save();
            },
        );

        if ($status !== Password::PASSWORD_RESET) {
            return back()
                ->withInput($request->only('email'))
                ->withErrors(['email' => 'This reset link is invalid or has expired. Please request a new one.']);
        }

        return redirect()
            ->route('frontend.players.login')
            ->with('status', 'Your password has been changed. Sign in with your new password.');
    }
}
