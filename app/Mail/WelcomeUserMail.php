<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;

use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Attachment;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class WelcomeUserMail extends Mailable
{
    use Queueable, SerializesModels;

    public array $userData;


    public function __construct(array $userData)
    {
        $this->userData = $userData;
    }

    public function envelope(): Envelope
    {
        return new Envelope(
            subject: '¡Bienvenido a nuestra plataforma!',
        );
    }

    public function content(): Content
    {
        return new Content(
            view: 'emails.welcome',
            with: ['nombre' => $this->userData['name']],
        );
    }

    public function attachments(): array
    {
        return [];
    }
}