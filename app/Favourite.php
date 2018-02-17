<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Favourite extends Model
{
	use RecordsActivites;

    protected $guarded = [];

    public function favorited()
    {
    	return $this->morphTo();
    }

    public static function gotLastWord($string)
    {
    	$array = explode('\\', $string);

    	return array_values(array_slice($array, -1))[0];
    }

    public static function gotFirstWord($string)
    {
        $array = explode('/', $string);

        return $array[0];
    }
}
