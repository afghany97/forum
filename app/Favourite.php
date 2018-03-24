<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Favourite extends Model
{
	use RecordsActivites;

    // unguard all fileds of favourites table "able to fill"

    protected $guarded = [];

    public function favorited() 
    {
        // fetch the favorited object

    	return $this->morphTo();
    }

    public static function gotLastWord($string) // return the last word of given string 
    {
    	$array = explode('\\', $string);

    	return array_values(array_slice($array, -1))[0];
    }

    public static function gotFirstWord($string) // return the first word of given string
    {
        $array = explode('/', $string);

        return $array[0];
    }
}
