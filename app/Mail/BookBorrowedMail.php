<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class BookBorrowedMail extends Mailable
{
    use Queueable, SerializesModels;

    public function __construct(public array $notificationData)
    {
    }

    public function envelope(): Envelope
    {
        return new Envelope(
            subject: '【図書館アプリ】貸出完了のお知らせ',
        );
    }

    public function content(): Content
    {
        return new Content(
            view: 'emails.book-borrowed',
            with: [
                'notificationData' => $this->notificationData,
            ],
        );
    }
}
