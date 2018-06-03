<?php

namespace App\Listeners;

use App\Events\ThreadLocked;

class NofityThreadOwner
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
     * @param  ThreadLocked  $event
     * @return void
     */
    public function handle(ThreadLocked $event)
    {
        // notify the thread owner when his thread locked by supervisor

        $event->thread->user->notify(new \App\Notifications\ThreadLocked($event->thread));
    }
}
