<?php

namespace App\Http\Controllers;

use App\Models\RegistrationDocument;
use Illuminate\Support\Facades\Storage;
use Symfony\Component\HttpFoundation\StreamedResponse;

/**
 * Serves registration documents from the private disk. Registered as an
 * authenticated admin panel route, so only signed-in admins reach it.
 * (Player access to their own documents is added with the player area.)
 */
class RegistrationDocumentController extends Controller
{
    public function __invoke(RegistrationDocument $document): StreamedResponse
    {
        abort_unless(Storage::disk('local')->exists($document->file_path), 404);

        return Storage::disk('local')->download(
            $document->file_path,
            $document->original_name ?: basename($document->file_path),
        );
    }
}
