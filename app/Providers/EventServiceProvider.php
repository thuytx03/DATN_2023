<?php

namespace App\Providers;

use App\Events\SeatCancelled;
use App\Events\SeatSelected;
use App\Listeners\SeatCancelledListener;
use App\Listeners\SeatSelectedListener;
use Illuminate\Auth\Events\Registered;
use Illuminate\Auth\Listeners\SendEmailVerificationNotification;
use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Event;

class EventServiceProvider extends ServiceProvider
{
    /**
     * The event listener mappings for the application.
     *
     * @var array<class-string, array<int, class-string>>
     */
    protected $listen = [
        Registered::class => [
            SendEmailVerificationNotification::class,
        ],
        SeatSelected::class => [
            SeatSelectedListener::class
        ],
        SeatCancelled::class => [
            SeatCancelledListener::class
        ],

    ];

    /**
     * Register any events for your application.
     *
     * @return void
     */
    public function boot()
    {
        Event::listen(
            SeatSelected::class,
            [
                SeatSelectedListener::class, 'handle'
            ],
            SeatCancelled::class,
            [
                SeatCancelledListener::class, 'handle'
            ],

        );
    }
}
