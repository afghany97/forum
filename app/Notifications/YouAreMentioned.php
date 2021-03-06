<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;

class YouAreMentioned extends Notification
{
    use Queueable;

    public $reply;

    /**
     * YouAreMentioned constructor.
     * @param $reply
     */
    public function __construct($reply)
    {
        $this->reply = $reply;
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
            'message' => $this->reply->User->name . " mentioned you at " . $this->reply->thread->title,

            'link' => $this->reply->path()
        ];
    }
}
