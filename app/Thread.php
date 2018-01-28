<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

use App\User;

use App\Reply;

class Thread extends Model
{
   	protected $guarded = [];

   	public function User()
   	{
   		return $this->belongsTo(User::class);
   	}

   	public function Replies()
   	{
   		return $this->hasMany(Reply::class);
   	}

   	public function path()
   	{
   		return '/threads/' . $this->id;
   	}
}
