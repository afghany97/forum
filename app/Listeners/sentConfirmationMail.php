<?php

namespace App\Listeners;

use App\Mail\ConfirmYourEmail;
use Illuminate\Auth\Events\Registered;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Support\Facades\Mail;

class sentConfirmationMail
{


    public function handle(Registered $event)
    {
        // send confirmation mail to new user

        Mail::to($event->user)->send(new ConfirmYourEmail($event->user));
    }
}
