<?php

namespace App\Mail;

use App\Models\UserProjection;
use Illuminate\Support\Facades\Mail;

class MailService
{
    public function sendUserRegistered(UserProjection $user): void
    {
        Mail::to($user->email)->send(new UserRegisterMail($user));
    }
}
