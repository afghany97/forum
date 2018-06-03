<?php

namespace App\Listeners;

use App\Events\ThreadLocked;

class NofityThreadSubscribers
{

    /**
     * Handle the event.
     *
     * @param  ThreadLocked  $event
     * @return void
     */
    public function handle(ThreadLocked $event)
    {
        // notify thread subscribes when supervisor lock subscribed thread
        $event->thread->subscribes

            ->each->notifyThreadHasLocked($event->thread);
    }
}
