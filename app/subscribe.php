<?php

namespace App;

use App\Notifications\ThreadLockedForSubscribes;
use App\Notifications\ThreadUpdated;

use App\Notifications\ThreadUpdatedII;
use Illuminate\Database\Eloquent\Model;

class subscribe extends Model
{
    // unguard all fileds of subscribes table "able to fill"

    protected $guarded = [];

    public function user() // create the relationship between subscribe and uses table
    {
    	return $this->belongsTo(User::class);
    }

    public function notifyThreadHasNewReply($reply) // notfiy subscribe user
    {
	    $this->user->notify(new ThreadUpdated($reply->thread , $reply));
    }

    public function notifyThreadHasUpdated($thread) // notfiy subscribe user
    {
        $this->user->notify(new ThreadUpdatedII($thread));
    }

    public function notifyThreadHasLocked($thread)
    {
        $this->user->notify(new ThreadLockedForSubscribes($thread));
    }

}
