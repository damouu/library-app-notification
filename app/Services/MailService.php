<?php

namespace App\Services;

use App\DTO\BorrowCreatedEventDTO;
use App\DTO\ReturnCreatedEventDTO;
use App\Mail\BookBorrowedMail;
use App\Mail\BookReturnedMail;
use App\Mail\UserRegisterMail;
use App\Models\UserProjection;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Mail;

class MailService
{
    public function __construct
    (
        private TracingService $tracingService
    )
    {
    }

    public function sendUserRegistered(UserProjection $user): void
    {
        $this->tracingService->trace(
            'mail.user_registered.send',
            function () use ($user) {
                Mail::to($user->email)->send(new UserRegisterMail($user));
            }, [
                'mail.template' => UserRegisterMail::class,
                'mail.transport' => config('mail.default'),
            ]
        );
    }

    public function sendBorrow(BorrowCreatedEventDTO $borrowCreatedEventDTO, UserProjection $user, Collection $books): void
    {
        $this->tracingService->trace(
            'mail.borrow_created.send',
            function () use ($borrowCreatedEventDTO, $user, $books) {
                Mail::to($user->email)->send(new BookBorrowedMail($borrowCreatedEventDTO, $user, $books));
            }, [
                'mail.template' => BookBorrowedMail::class,
                'mail.transport' => config('mail.default'),
                'books.count' => $books->count(),
            ]
        );
    }

    public function sendReturn(ReturnCreatedEventDTO $returnCreatedEventDTO, UserProjection $user, Collection $books): void
    {
        $this->tracingService->trace(
            'mail.return_created.send',
            function () use ($returnCreatedEventDTO, $user, $books) {
                Mail::to($user->email)->send(new BookReturnedMail($returnCreatedEventDTO, $user, $books));
            }, [
                'mail.template' => BookReturnedMail::class,
                'mail.transport' => config('mail.default'),
                'books.count' => $books->count(),
            ]
        );
    }
}
