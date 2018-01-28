<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

use App\User;

use App\Thread;

class Reply extends Model
{
    protected $guarded = [];

    public function User()
    {
    	return $this->belongsTo(User::class);
    }
    public function Thread()
    {
    	return $this->belongsTo(Thread::class);
	}
}
