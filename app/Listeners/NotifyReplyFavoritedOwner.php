<?php

namespace App\Listeners;

use App\Events\ReplyFavorited;
use App\Notifications\ReplyFavoritedForOwner;

class NotifyReplyFavoritedOwner
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
     * @param  ReplyFavorited  $event
     * @return void
     */
    public function handle(ReplyFavorited $event)
    {
        if($event->reply->user->id != auth()->id()){

            $event->reply->user->notify(new ReplyFavoritedForOwner($event->reply));
        }
    }
}
