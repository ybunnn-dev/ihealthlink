<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class EmailChangeVerification extends Mailable
{
    use Queueable, SerializesModels;

    public $plainCode;
    public $newEmail;

    public function __construct($plainCode, $newEmail)
    {
        $this->plainCode = $plainCode;
        $this->newEmail = $newEmail;
    }

    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Email Change Verification Code',
        );
    }

    public function content(): Content
    {
        return new Content(
            view: 'emails.email-change-verification',
        );
    }
}
