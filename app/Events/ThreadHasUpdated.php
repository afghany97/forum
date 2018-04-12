<?php

namespace App\Events;

use Illuminate\Queue\SerializesModels;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Broadcasting\InteractsWithSockets;

class ThreadHasUpdated
{
    use Dispatchable, InteractsWithSockets, SerializesModels;


    public $thread;

    /**
     * Create a new event instance.
     *
     * @param $thread
     */
    public function __construct($thread)
    {
        $this->thread = $thread;
    }
}
