<?php

namespace App\Providers;

use App\Events\BuyEvent;
use App\Events\EventRegistry;
use App\Listeners\BuyEventListener;
use App\Listeners\SendEventRegistryNotification;
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
            BuyEventListener::class
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
            [
                EventRegistry::class,
                BuyEvent::class
            ],
            [
                [SendEventRegistryNotification::class, 'handle'],
                [BuyEventListener::class, 'handle'],
            ]
            
    )   ;
    }
}
