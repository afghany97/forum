<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

use App\User;

use App\Channel;

use App\Favourite;

use App\Reply;

class Thread extends Model
{
      use RecordsActivites , ableToFavourite;

      // unguard all fileds of replies table "able to fill"

   	protected $guarded = [];

      public static function boot()
      {
         parent::boot();

         static::addGlobalScope('channel' , function($builder)
         {
            $builder->with('Channel');
         });

         static::addGlobalScope('User', function($builder)
         {
            $builder->with('User');
         });

         static::deleting(function($thread){

               $thread->replies->each->delete();   
         });

      }
      // create the relationship between threads and users table

   	public function User()
   	{
   		return $this->belongsTo(User::class);
   	}

      // create the relationship between threads and channels table

      public function Channel()
      {
         return $this->belongsTo(Channel::class);
      }
      
      // create the relationship between threads and replies table

   	public function Replies()
   	{
   		return $this->hasMany(Reply::class);
   	}

   	public function path()
   	{
         // return the path of specific thread

         return '/threads/' . $this->Channel->name . '/' .  $this->id;

   	}

      public function addReply(array $data)
      {
         // expect array of data "user id and body of reply"

         // return instance of the added reply
         
         return $this->Replies()->create([

            'body' => $data['body'],
            
            'user_id' => $data['user_id']
         
         ]);
      }

      public static function addThread(array $data)
      {
         // expect array of data "thread title and body"

         // return instance of the added Thread

         return static::create([

            'channel_id' => $data['channel_id'],
            
            'user_id' => auth()->id(),

            'title' => $data['title'],

            'body' => $data['body']
         ]);
      }

      public function scopeFilter($query,$filters)
      {
         // msh 3arf aktb eh bas zay ma 7adrtko shayfen :"D 

         return $filters->apply($query);
      }

      public function subscribe($userId = null)
      {
         $this->subscribes()
         
         ->create([
         
            'user_id' => $userId ?: auth()->id()
         ]);
      }

      public function unsubscribe($userId = null)
      {
         $this->subscribes()

         ->where('user_id' , $userId ?: auth()->id())

         ->delete();
      }

      public function subscribes()
      {
         return $this->hasMany('App\subscribe');
      }

}
