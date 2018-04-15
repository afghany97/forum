<?php

namespace App\Http\Controllers;

use App\Events\ThreadLocked;
use App\Thread;

class LockThreadControllers extends Controller
{

    public function __construct()
    {
        $this->middleware('supervisor');
    }

    public function update(Thread $thread)
    {
        $thread->lockToggle();

        event(new ThreadLocked($thread));

        return back();
    }
}
