<?php

namespace App\Listeners;

use App\Events\ThreadDeleted;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

class NofityThreadSubscribersI
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
        //
    }
}
