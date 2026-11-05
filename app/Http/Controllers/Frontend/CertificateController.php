<?php

namespace App\Http\Controllers\Frontend;

use App\Enums\RegistrationStatus;
use App\Http\Controllers\Controller;
use App\Http\Requests\Frontend\LookupCertificatesRequest;
use App\Models\Certificate;
use App\Models\Player;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\Str;
use Illuminate\View\View;

/**
 * Digital Certificates page: lookup by Player ID + date of birth (approved
 * players only) with 30-minute signed download links, and the public
 * verification page the certificate QR codes point to.
 */
class CertificateController extends Controller
{
    /**
     * How long a download link from the lookup stays valid.
     */
    private const int LINK_MINUTES = 30;

    public function index(Request $request): View
    {
        $player = $request->session()->has('lookup_player')
            ? Player::query()
                ->with(['certificates' => fn ($query) => $query->with('event')->latest('issued_on')->latest('id')])
                ->find($request->session()->get('lookup_player'))
            : null;

        return view('frontend.certificates.index', [
            'lookupPlayer' => $player,
            'downloadLinks' => $player?->certificates->mapWithKeys(fn (Certificate $certificate): array => [
                $certificate->id => URL::temporarySignedRoute('frontend.certificates.download', now()->addMinutes(self::LINK_MINUTES), $certificate, absolute: false),
            ]),
        ]);
    }

    /**
     * Every wrong combination gets the same message, so the form cannot be
     * used to find out which Player IDs exist or whose certificates they are.
     */
    public function lookup(LookupCertificatesRequest $request): RedirectResponse
    {
        $player = Player::query()
            ->where('registration_no', Str::upper(trim($request->validated('player_id'))))
            ->where('status', RegistrationStatus::Approved)
            ->whereDate('date_of_birth', $request->date('date_of_birth'))
            ->first();

        if (! $player) {
            return redirect()
                ->to(route('frontend.certificates.index').'#find-certificate')
                ->withInput($request->only('player_id'))
                ->with('lookup_failed', true);
        }

        return redirect()
            ->to(route('frontend.certificates.index').'#lookup-results')
            ->withInput($request->only('player_id'))
            ->with('lookup_player', $player->id);
    }

    public function verify(string $code): Response
    {
        $certificate = Certificate::query()
            ->with(['player', 'event'])
            ->where('verification_code', $code)
            ->first();

        return response()->view('frontend.certificates.verify', ['certificate' => $certificate], $certificate ? 200 : 404);
    }
}
