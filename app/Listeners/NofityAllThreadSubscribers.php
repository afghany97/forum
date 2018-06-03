<?php

namespace App\Listeners;

use App\Events\ThreadHasNewReply;

class NofityAllThreadSubscribers
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
     * @param  ThreadHasNewReply  $event
     * @return void
     */
    public function handle(ThreadHasNewReply $event)
    {
        $event->thread->subscribes

        // find all subscribers except authenticated user

        ->where('user_id' , '!=' , $event->reply->user_id)
        
        // notify users
        
        ->each->notifyThreadHasNewReply($event->reply);

    }
}
