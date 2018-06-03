<?php

namespace App\Providers;

use Illuminate\Auth\Events\Registered;
use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;

class EventServiceProvider extends ServiceProvider
{
    /**
     * The event listener mappings for the application.
     *
     * @var array
     */
    protected $listen = [
        'App\Events\ThreadHasNewReply' => [
            'App\Listeners\NofityAllThreadSubscribers',
            'App\Listeners\NofityAllMentionedUsers',
        ],
        Registered::class =>[
            'App\Listeners\sentConfirmationMail',

        ],
        'App\Events\ThreadHasUpdated' => [
            'App\Listeners\NofityAllThreadSubscribersII',
        ],
        'App\Events\ThreadLocked' => [
            'App\Listeners\NofityThreadOwner',
            'App\Listeners\NofityThreadSubscribers',
        ],

         'App\Events\ThreadDeleted' => [
            'App\Listeners\NofityThreadOwnerI',
            'App\Listeners\NofityThreadSubscribersI',
        ]
        ];

    /**
     * Register any events for your application.
     *
     * @return void
     */
    public function boot()
    {
        parent::boot();

        //
    }
}
