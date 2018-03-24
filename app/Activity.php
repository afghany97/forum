<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Activity extends Model
{
    // unguard all fileds of activites table "able to fill"

   	protected $guarded = [];

    // load the user relationship with each avtivity object

    protected $with = ['User'];

   	public function subject() // fetch the activity object
   	{
   		return $this->morphTo();
   	}

   	public function User() // create the replationship between activites and user tables
   	{
   		return $this->belongsTo(User::class);
   	}

      public static function feeds($user , $take = 50) // fetch the user activity feeds
      {
        // accept 2 prams ' user requierd , take optional' 

        // return the user feeds

        return static::where('user_id' , $user->id)
        
            ->latest() // in descending order
           
            ->take($take) // only take "number" of records
           
            ->get() // fetch the records
           
            ->groupBY(function($activity){ // group by date in this format "year - month - day"

               return $activity->created_at->format('y-m-d');
           
           });
      }
}
