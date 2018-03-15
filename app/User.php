<?php

namespace App;

use Illuminate\Notifications\Notifiable;

use Illuminate\Foundation\Auth\User as Authenticatable;

use App\Thread;

use App\Reply;

class User extends Authenticatable
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    // public static function boot()
    // {
    //     parent::boot();

    //     static::addGlobalScope('activites',  function($user)
    //     {
    //         $user->with('activites');
    //     });
    // }
    // create the relationship between users and threads table

    public function Threads()
    {
        return $this->hasMany(Thread::class)->latest();
    }
    
    // create the relationship between users and replies table

    public function Replies()
    {
        return $this->hasMany(Reply::class);
    }

    public function activites()
    {
        return $this->hasMany(Activity::class);
    }
    
    public function lastReply()
    {
      return $this->hasOne(Reply::class)->latest();
    }

    // override getRouteKeyName to make routes fetch the model binding by column name not priamry key "defualt" 

    public function getRouteKeyName()
    {
        return 'name';
    }

    public function getVistedThreadCasheKey($thread)
    {
        return sprintf("visted.%s.thread.%s",$this->id , $thread->id);
    }
}
