<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

use App\User;

use App\Thread;

class Reply extends Model
{
	// unuard all fileds of replies table "able to fill"

    protected $guarded = [];

	// create the relationship between replies and users table

   public function User()
   {
       return $this->belongsTo(User::class);
   }

	// create the relationship between replies and threads table

    public function Thread()
    {
    	return $this->belongsTo(Thread::class);
	}
}
