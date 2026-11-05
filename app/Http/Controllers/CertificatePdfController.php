<?php

namespace App\Http\Controllers;

use App\Models\Certificate;
use Illuminate\Support\Facades\Storage;
use Symfony\Component\HttpFoundation\StreamedResponse;

/**
 * Serves certificate PDFs from the private disk. Its routes decide who may
 * reach it: the authenticated admin panel route, and the public route that
 * only accepts the short-lived signed links from the certificate lookup.
 * (The owning player's own route is added with the player area.)
 */
class CertificatePdfController extends Controller
{
    public function __invoke(Certificate $certificate): StreamedResponse
    {
        if (! $certificate->pdf_path || ! Storage::disk('local')->exists($certificate->pdf_path)) {
            $certificate->generatePdf();
        }

        return Storage::disk('local')->download($certificate->pdf_path, $certificate->certificate_no.'.pdf');
    }
}
