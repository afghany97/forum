<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;

class ThreadLocked extends Notification
{
    use Queueable;
    public $thread;

    /**
     * Create a new notification instance.
     *
     * @param $thread
     */
    public function __construct($thread)
    {
        //
        $this->thread = $thread;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function via($notifiable)
    {
        return ['database'];
    }

    public function toArray($notifiable)
    {
        return [
            'message' => $this->thread->is_locked ? "your thread locked by supervisor or administrator" : "your thread un-locked by supervisor or administrator" ,

            'link' => $this->thread->path()
        ];
    }
}
