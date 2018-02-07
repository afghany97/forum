<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Channel extends Model
{

	// create the relationship between channels and threads table

    public function Threads()
    {
    	return $this->hasMany(Thread::class);
    }
}
