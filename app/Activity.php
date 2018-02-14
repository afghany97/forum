<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Activity extends Model
{
   	protected $guarded = [];

   	// public static function boot()
   	// {
   	// 	parent::boot();

   	// 	static::addGlobalScope('subject' , function($query)
   	// 	{
   	// 		$query->with('subject');
   	// 	});
   	// }

   	public function subject()
   	{
   		return $this->morphTo();
   	}

      // create the replationship between activites and user tables

   	public function User()
   	{
   		return $this->belongsTo(User::class);
   	}

      public static function feeds($user , $take = 50)
      {
         return static::where('user_id' , $user->id)
        
            ->latest()
           
            ->with('subject')
           
            ->take($take)
           
            ->get()
           
            ->groupBY(function($activity){

               return $activity->created_at->format('y-m-d');
           
           });
      }
}
