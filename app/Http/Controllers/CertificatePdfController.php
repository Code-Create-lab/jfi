<?php

namespace App\Http\Controllers;

use App\Models\Certificate;
use Symfony\Component\HttpFoundation\StreamedResponse;

/**
 * Serves certificate PDFs from the private disk. Its routes decide who may
 * reach it: the authenticated admin panel route, and the public route that
 * only accepts the short-lived signed links from the certificate lookup.
 * Players download their own from the player area (Player\CertificateController).
 */
class CertificatePdfController extends Controller
{
    public function __invoke(Certificate $certificate): StreamedResponse
    {
        return $certificate->download();
    }
}
