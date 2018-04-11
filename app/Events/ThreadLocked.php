<?php

namespace App\Events;

use App\Thread;
use Illuminate\Queue\SerializesModels;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Broadcasting\InteractsWithSockets;

class ThreadLocked
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $thread;

    public function __construct(Thread $thread)
    {
        $this->thread = $thread;
    }

}
