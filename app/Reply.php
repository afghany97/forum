<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

use App\User;

use App\Favourite;

use App\Thread;

class Reply extends Model
{
    use RecordsActivites , ableToFavourite;

  	// unuard all fileds of replies table "able to fill"

    protected $guarded = [];

    public static function boot()
    {
      parent::boot();

      static::addGlobalScope('user' , function($builder)
      {
        $builder->with('User');
      });

      static::addGlobalScope('favourites' , function($builder)
      {
        $builder->with('favourites');
      });
    }

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
