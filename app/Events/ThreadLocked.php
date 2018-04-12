<?php

namespace App\Events;

use Illuminate\Queue\SerializesModels;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Broadcasting\InteractsWithSockets;

class ThreadLocked
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $thread;

    /**
     * ThreadLocked constructor.
     * @param $thread
     */
    public function __construct($thread)
    {
        $this->thread = $thread;
    }

}
