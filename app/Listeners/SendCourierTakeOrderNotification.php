<?php

namespace App\Listeners;

use App\Models\User;
use App\Notifications\CourierTakeOrderAdminNotification;
use App\Notifications\CourierTakeOrderCustomerNotification;
use App\Notifications\CourierTakeOrderNotification;
use App\Notifications\NewOrderCreatedAdminNotification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class SendCourierTakeOrderNotification
{
    public function handle(object $event): void
    {
        $event->order->customer->notify(new CourierTakeOrderCustomerNotification($event->order));

        $event->order->courier->notify(new CourierTakeOrderNotification($event->order));

        User::role('admin')->get()->each(function ($user) use ($event){
            $user->notify(new CourierTakeOrderAdminNotification($event->order));
        });
    }
}
