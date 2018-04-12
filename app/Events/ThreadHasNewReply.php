<?php

namespace App\Events;

use Illuminate\Queue\SerializesModels;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Broadcasting\InteractsWithSockets;

class ThreadHasNewReply
{
    use Dispatchable, InteractsWithSockets, SerializesModels;


    public $thread , $reply;

    /**
     * Create a new event instance.
     *
     * @param $thread
     * @param $reply
     */
    public function __construct($thread , $reply)
    {
        $this->reply = $reply;

        $this->thread = $thread;
    }
}
