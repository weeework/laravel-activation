<?php

namespace App\Listeners\Auth;

use Mail;
use App\Events\Auth\UserRegistered;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use App\Mail\Auth\ActivationEmail;

class SendActivationEmail
{
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     *
     * @param  UserRegistered  $event
     * @return void
     */
    public function handle(UserRegistered $event)
    {
        if ($event->user->active) {
            return;
        }

        Mail::to($event->user->email)->send(new ActivationEmail($event->user));
    }
}
