<?php

namespace App\Mail;

use App\DTO\BorrowCreatedEventDTO;
use App\Models\UserProjection;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Collection;

class BookBorrowedMail extends Mailable
{
    use Queueable, SerializesModels;

    public function __construct(
        public BorrowCreatedEventDTO $borrowCreatedEventDTO,
        public UserProjection        $userProjection,
        public Collection            $books)
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
                'borrowEvent' => $this->borrowCreatedEventDTO,
                'userProjection' => $this->userProjection,
                'books' => $this->books,
            ],
        );
    }
}
