<?php

namespace App\Mail;

use App\Models\Player;
use App\Models\StateAssociation;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class RegistrationApproved extends Mailable
{
    use Queueable, SerializesModels;

    public function __construct(public Player|StateAssociation $registrant) {}

    public function envelope(): Envelope
    {
        return new Envelope(
            subject: $this->registrant instanceof Player
                ? 'Your Jumpball Federation of India registration is approved'
                : 'Your state association application is approved',
        );
    }

    public function content(): Content
    {
        return new Content(markdown: 'emails.registration-approved');
    }
}
