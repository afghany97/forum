<?php

namespace App;

use App\Notifications\ThreadUpdated;

use Illuminate\Database\Eloquent\Model;

class subscribe extends Model
{
    protected $guarded = [];

    public function user()
    {
    	return $this->belongsTo(User::class);
    }

    public function notify($reply)
    {
	    $this->user->notify(new ThreadUpdated($reply->thread , $reply));
    	
    }
}
