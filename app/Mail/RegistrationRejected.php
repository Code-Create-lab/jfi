<?php

namespace App\Mail;

use App\Models\Player;
use App\Models\StateAssociation;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class RegistrationRejected extends Mailable
{
    use Queueable, SerializesModels;

    public function __construct(public Player|StateAssociation $registrant) {}

    public function envelope(): Envelope
    {
        return new Envelope(
            subject: $this->registrant instanceof Player
                ? 'Update on your Jumpball Federation of India registration'
                : 'Update on your state association application',
        );
    }

    public function content(): Content
    {
        return new Content(markdown: 'emails.registration-rejected');
    }
}
