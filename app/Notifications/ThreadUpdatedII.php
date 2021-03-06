<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;

class ThreadUpdatedII extends Notification
{
    use Queueable;

    public  $thread;

    /**
     * Create a new notification instance.
     *
     * @param $thread
     */
    public function __construct($thread)
    {
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

    /**
     * Get the array representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function toArray($notifiable)
    {
        return [
            'message' => $this->thread->user->name . " updated his thread " . $this->thread->title,

            'link' => $this->thread->path()
        ];
    }
}
