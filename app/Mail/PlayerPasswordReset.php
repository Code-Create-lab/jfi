<?php

namespace App\Mail;

use App\Models\Player;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

/**
 * The password reset link for the player area, sent through the "players"
 * password broker (Player::sendPasswordResetNotification()).
 */
class PlayerPasswordReset extends Mailable
{
    use Queueable, SerializesModels;

    public function __construct(public Player $player, public string $token) {}

    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Reset your Jumpball Federation of India player password',
        );
    }

    public function content(): Content
    {
        return new Content(
            markdown: 'emails.player-password-reset',
            with: [
                'resetUrl' => route('player.password.reset', ['token' => $this->token, 'email' => $this->player->email]),
                'expiresInMinutes' => config('auth.passwords.players.expire'),
            ],
        );
    }
}
