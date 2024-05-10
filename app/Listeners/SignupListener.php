<?php

namespace App\Listeners;

use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailer;
use App\Events\SignupEvent;
use App\Mail\ConfirmationMail;


class SignupListener implements ShouldQueue
{
    /**
     * Create the event listener.
     */
    public function __construct(private Mailer $mailer)
    {
        //
    }

    /**
     * Send an email to the user with a random generated string to 
     * confirm his mail address.
     */
    public function handle(SignupEvent $event): void
    {
        $this->mailer->send(
            new ConfirmationMail($event->mail, $event->confirmation_token)
        );
    }
}
