<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

use App\User;

use App\Reply;

class Thread extends Model
{
      // unuard all fileds of replies table "able to fill"

   	protected $guarded = [];

      // create the relationship between threads and users table

   	public function User()
   	{
   		return $this->belongsTo(User::class);
   	}
      
      // create the relationship between threads and replies table

   	public function Replies()
   	{
   		return $this->hasMany(Reply::class);
   	}


   	public function path()
   	{
         // return the path of specific thread

   		return '/threads/' . $this->id;
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
            
            'user_id' => auth()->id(),

            'title' => $data['title'],

            'body' => $data['body']
         ]);
      }
}
