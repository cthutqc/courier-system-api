<?php

namespace App\Listeners;

use App\Notifications\AccountConfirmedNotification;

class SendAccountConfirmedNotification
{
    public function handle(object $event): void
    {
        $event->user->notify(new AccountConfirmedNotification());
    }
}
