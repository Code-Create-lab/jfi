<?php

namespace App\Http\Controllers\Player;

use App\Http\Controllers\Controller;
use App\Models\Certificate;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\StreamedResponse;

/**
 * Downloads one of the signed-in player's own certificates. Another
 * player's certificate is a 404, so its existence is not confirmed.
 * The route also requires an approved registration (EnsurePlayerApproved).
 */
class CertificateController extends Controller
{
    public function __invoke(Request $request, Certificate $certificate): StreamedResponse
    {
        abort_unless($certificate->player_id === $request->user('player')->id, 404);

        return $certificate->download();
    }
}
