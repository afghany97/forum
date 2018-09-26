<?php

namespace App\Listeners;

use App\Events\ThreadFavorited;
use App\Notifications\ThreadFavoritedForOwner;

class NotifyThreadFavoritedOwner
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
     * @param  ThreadFavorited  $event
     * @return void
     */
    public function handle(ThreadFavorited $event)
    {
        if(auth()->id() != $event->thread->user->id){

            $event->thread->user->notify(new ThreadFavoritedForOwner($event->thread));
        }

    }
}
