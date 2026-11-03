<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Http\Requests\Frontend\StoreContactMessageRequest;
use App\Models\ContactMessage;
use Illuminate\Http\RedirectResponse;

/**
 * Saves Contact form messages; admins read them in /admin.
 */
class ContactController extends Controller
{
    public function store(StoreContactMessageRequest $request): RedirectResponse
    {
        ContactMessage::create($request->safe()->only(['name', 'email', 'phone', 'subject', 'message']));

        return redirect()
            ->route('frontend.contact')
            ->with('status', 'Thank you. Your message has been sent to the federation office.');
    }
}
