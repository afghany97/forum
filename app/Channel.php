<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Channel extends Model
{
    public function Threads() // create the relationship between channels and threads table
    {
    	return $this->hasMany(Thread::class);
    }

    public function getRouteKeyName() // override getRouteKeyName to make routes fetch the model binding by column name not priamry key "defualt" 
    {
    	return 'name';
    }
}
