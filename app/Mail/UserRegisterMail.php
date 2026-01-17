<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class UserRegisterMail extends Mailable
{
    use Queueable, SerializesModels;

    public function __construct(public string $bookTitle)
    {
    }

    public function envelope(): Envelope
    {
        return new Envelope(
            subject: '【図書館アプリ】登録完了のお知らせ！',
        );
    }

    public function content(): Content
    {
        return new Content(
            view: 'emails.user-registration',
        );
    }
}
