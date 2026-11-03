<?php

namespace App\Mail;

use App\Models\Player;
use App\Models\StateAssociation;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

/**
 * Sent right after a public player or state association registration is
 * saved (status pending).
 */
class RegistrationReceived extends Mailable
{
    use Queueable, SerializesModels;

    public function __construct(public Player|StateAssociation $registrant) {}

    public function envelope(): Envelope
    {
        return new Envelope(
            subject: $this->registrant instanceof Player
                ? 'Your Jumpball Federation of India registration has been received'
                : 'Your state association application has been received',
        );
    }

    public function content(): Content
    {
        return new Content(markdown: 'emails.registration-received');
    }
}
