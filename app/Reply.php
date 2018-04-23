<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

use Carbon\Carbon;

class Reply extends Model
{
    use RecordsActivites, ableToFavourite;

    // unuard all fileds of replies table "able to fill"

    protected $guarded = [];

    protected $appends = ['isBest'];

    public static function boot()
    {
        parent::boot();

        static::addGlobalScope('user', function ($builder) {
            $builder->with('User');
        });

        static::addGlobalScope('favourites', function ($builder) {
            $builder->with('favourites');
        });

        static::created(function ($reply) {
            $reply->thread->increment('replies_count');
        });

        static::deleted(function ($reply) {

            if($reply->isBest)

                $reply->thread->update(['best_reply_id' => null]);

            $reply->thread->decrement('replies_count');
        });
    }

    public function User() // create the relationship between replies and users table
    {
        return $this->belongsTo(User::class);
    }

    public function Thread() // create the relationship between replies and threads table
    {
        return $this->belongsTo(Thread::class);
    }

    public function justPublished()
    {
        // return bool value if the reply created more than 1 min ago

        return $this->created_at->gt(Carbon::now()->subMinute());
    }

    public function path()
    {
        // return the path of specific reply

        return $this->thread->path() . "#reply-{$this->id}";
    }

    public function mentionedUsers()
    {
        // find the mentioned users

        preg_match_all('/\@([\w\-]+)/', $this->body, $matches);

        // return the mentioned users

        return $matches[1];

    }

    public function setBodyAttribute($body) // set body accessors
    {

        $this->attributes['body'] =

            preg_replace('/\@([\w\-]+)/', '<a href="/profiles/$1">$0</a>', $body); // find the mentioned user name and replace it to a tag 'link to user profile'
    }

    public function isBest()
    {
        return $this->id == $this->thread->best_reply_id;
    }

    public function getIsBestAttribute()
    {
        return $this->isBest();
    }
}
