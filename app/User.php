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
        'name', 'email', 'password', 'avatar_path' , 'confirmed' , 'confirmation_token'
    ];

    protected $casts = [
      'confirmed' => 'boolean'
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

    // create the relationship between users and activites table

    public function activites()
    {
        return $this->hasMany(Activity::class);
    }
    
    public function lastReply()
    {
        // return the last reply for user

        return $this->hasOne(Reply::class)->latest();
    }

    public function getRouteKeyName() // override getRouteKeyName to make routes fetch the model binding by column name not priamry key "defualt" 
    {
        return 'name';
    }

    public function getVistedThreadCasheKey($thread)
    {
        // return the key to save @ cashe to mark visted thread by each user , format of key visted ['user_id'] thread ['thread_id']
        
        return sprintf("visted.%s.thread.%s",$this->id , $thread->id);
    }
}
