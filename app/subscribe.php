<?php

namespace App;

use App\Notifications\ThreadUpdated;

use Illuminate\Database\Eloquent\Model;

class subscribe extends Model
{
    // unguard all fileds of subscribes table "able to fill"

    protected $guarded = [];

    public function user() // create the relationship between subscribe and uses table
    {
    	return $this->belongsTo(User::class);
    }

    public function notify($reply) // notfiy subscribe user
    {
	    $this->user->notify(new ThreadUpdated($reply->thread , $reply));
    }
}
