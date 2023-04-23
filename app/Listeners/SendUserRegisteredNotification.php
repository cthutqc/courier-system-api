<?php

namespace App\Listeners;

use App\Models\ConfirmCode;
use App\Models\User;
use App\Notifications\UserRegisteredAdminNotification;
use App\Notifications\UserRegisteredNotification;
use Illuminate\Support\Facades\Hash;

class SendUserRegisteredNotification
{
    public function handle(object $event): void
    {
        $confirmCode = fake()->randomNumber(6);

        ConfirmCode::create([
            'user_id' => $event->user->id,
            'code' => $confirmCode,
            'email' => $event->user->email,
        ]);

        $event->user->notify(new UserRegisteredNotification($confirmCode));

        User::role('admin')->get()->each(function ($user) use ($event){
            $user->notify(new UserRegisteredAdminNotification($event->user));
        });
    }
}
