<?php

namespace App\Providers;

use App\Events\AccountConfirmed;
use App\Events\CourierTakeOrder;
use App\Events\NewOrderCreated;
use App\Events\UserRegistered;
use App\Listeners\SendAccountConfirmedNotification;
use App\Listeners\SendCourierTakeOrderNotification;
use App\Listeners\SendNewOrderCreatedNotification;
use App\Listeners\SendUserRegisteredNotification;
use App\Models\User;
use App\Observers\UserObserver;
use Illuminate\Auth\Events\Registered;
use Illuminate\Auth\Listeners\SendEmailVerificationNotification;
use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Event;

class EventServiceProvider extends ServiceProvider
{
    /**
     * The event to listener mappings for the application.
     *
     * @var array<class-string, array<int, class-string>>
     */
    protected $listen = [
        UserRegistered::class => [
            SendUserRegisteredNotification::class
        ],
        NewOrderCreated::class => [
            SendNewOrderCreatedNotification::class
        ],
        CourierTakeOrder::class => [
            SendCourierTakeOrderNotification::class
        ],
    ];

    /**
     * Register any events for your application.
     */
    public function boot(): void
    {

    }

    /**
     * Determine if events and listeners should be automatically discovered.
     */
    public function shouldDiscoverEvents(): bool
    {
        return false;
    }
}
