<?php

namespace App\Listeners;

use App\Events\ThreadHasNewReply;

use App\User;

use App\Notifications\YouAreMentioned;

class NofityAllMentionedUsers
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
        // iterate for each mentioned user

        foreach ($event->reply->mentionedUsers() as $name) {

            // fetch the user by the name mentioned in reply body

            $user = User::whereName($name)->first();

            // check if the user exists

            if($user)
            {
                // notify the user

                $user->notify(new YouAreMentioned($event->reply));
            }
        }
    }
}
