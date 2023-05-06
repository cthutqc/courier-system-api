<?php

namespace App\Listeners;

use App\Models\User;
use App\Notifications\NewOrderCreatedAdminNotification;
use App\Notifications\NewOrderCreatedNotification;

class SendNewOrderCreatedNotification
{
    public function handle(object $event): void
    {
        $event->order->customer->notify(new NewOrderCreatedNotification($event->order));

        User::role('admin')->get()->each(function ($user) use ($event) {
            $user->notify(new NewOrderCreatedAdminNotification($event->order));
        });
    }
}
