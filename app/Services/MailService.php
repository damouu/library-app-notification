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
    public function sendUserRegistered(UserProjection $user): void
    {
        Mail::to($user->email)->send(new UserRegisterMail($user));
    }

    public function sendBorrow(BorrowCreatedEventDTO $borrowCreatedEventDTO, UserProjection $user, Collection $books): void
    {
        Mail::to($user->email)->send(new BookBorrowedMail($borrowCreatedEventDTO, $user, $books));
    }

    public function sendReturn(ReturnCreatedEventDTO $returnCreatedEventDTO, UserProjection $user, Collection $books): void
    {
        Mail::to($user->email)->send(new BookReturnedMail($returnCreatedEventDTO, $user, $books));
    }
}
