<?php

namespace App\Listeners;

use App\Events\ThreadLocked;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

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
        $event->thread->user->notify(new \App\Notifications\ThreadLocked($event->thread));
    }
}
