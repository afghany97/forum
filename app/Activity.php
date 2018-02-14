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

   	public function User()
   	{
   		return $this->belongsTo(User::class);
   	}
}
