<?php

namespace App\Mail;

use App\DTO\ReturnCreatedEventDTO;
use App\Models\UserProjection;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Collection;

class BookReturnedMail extends Mailable
{
    use Queueable, SerializesModels;

    public function __construct(
        public ReturnCreatedEventDTO $returnCreatedEventDTO,
        public UserProjection        $userProjection,
        public Collection            $books)
    {
    }

    public function envelope(): Envelope
    {
        return new Envelope(
            subject: '【図書館アプリ】返却完了のお知らせ！',
        );
    }

    public function content(): Content
    {
        return new Content(
            view: 'emails.book-returned',
            with: [
                'returnBorrowEvent' => $this->returnCreatedEventDTO,
                'userProjection' => $this->userProjection,
                'books' => $this->books,
            ],
        );
    }
}
