<?php

namespace App\Listeners;

use App\Events\ThreadDeleted;
use App\Notifications\ThreadDeletedForOwner;

class NofityThreadOwnerI
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
     * @param  ThreadDeleted  $event
     * @return void
     */

    public function handle(ThreadDeleted $event)
    {
        $event->thread->user->notify(new ThreadDeletedForOwner($event->thread));
    }
}
