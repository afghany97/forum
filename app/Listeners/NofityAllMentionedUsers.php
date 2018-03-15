<?php

namespace App\Listeners;

use App\Events\ThreadHasNewReply;

use App\Listeners\NofityAllMentionedUsers;

use Illuminate\Queue\InteractsWithQueue;

use Illuminate\Contracts\Queue\ShouldQueue;

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

        foreach ($event->reply->mentionedUsers() as $name) {
            
            $user = User::whereName($name)->first();

            if($user)
            {
                $user->notify(new YouAreMentioned($event->reply));
            }
        }
    }
}
