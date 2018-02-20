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

      static::created(function($reply)
      {
        $reply->thread->increment('replies_count');
      });

      static::deleted(function($reply)
      {
        $reply->thread->decrement('replies_count');
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

  public function path()
  {
    return $this->thread->path() . "#reply-{$this->id}";
  }

}
