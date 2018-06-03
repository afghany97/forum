<?php

namespace App\Listeners;

use App\Events\ThreadHasUpdated;

class NofityAllThreadSubscribersII
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
     * @param  ThreadHasUpdated  $event
     * @return void
     */
    public function handle(ThreadHasUpdated $event)
    {
        $event->thread->subscribes

            // find all subscribers except authenticated user

            ->where('user_id' , '!=' , $event->thread->user_id)

            // notify users

            ->each->notifyThreadHasUpdated($event->thread);
    }
}
