<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;


class PasswordResetVerification extends Mailable
{
    use Queueable, SerializesModels;

    public $plainToken;
    public $userEmail;

    public function __construct($plainToken, $userEmail)
    {
        $this->plainToken = $plainToken;
        $this->userEmail = $userEmail;
    }

    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Password Reset Verification Code - IHealthLink',
        );
    }

    public function content(): Content
    {
        return new Content(
            view: 'emails.password-reset-verification',
        );
    }
}
