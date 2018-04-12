<?php

namespace App;

use Carbon\Carbon;

use Illuminate\Database\Eloquent\Model;

use App\Events\ThreadHasNewReply;

class Thread extends Model
{
    use RecordsActivites, ableToFavourite;

    // unguard all fileds of threads table "able to fill"

    protected $guarded = [];

    // append isSubscribed attribute to thread object

    protected $appends = ['isSubscribed'];

    protected $casts = [
      'is_locked' => 'boolean'
    ];

    public static function boot()
    {
        parent::boot();

        static::addGlobalScope('channel', function ($builder) {
            $builder->with('Channel');
        });

        static::addGlobalScope('User', function ($builder) {
            $builder->with('User');
        });

        static::deleting(function ($thread) {

            $thread->replies->each->delete();
        });

        static::created(function ($thread) {

            $thread->update(['slug' => $thread->title]);
        });
    }

    public function User() // create the relationship between threads and users table
    {
        return $this->belongsTo(User::class);
    }

    public function Channel() // create the relationship between threads and channels table
    {
        return $this->belongsTo(Channel::class);
    }

    public function Replies() // create the relationship between threads and replies table
    {
        return $this->hasMany(Reply::class);
    }

    public function path()
    {
        // return the path of specific thread

        return '/threads/' . $this->Channel->name . '/' . $this->slug;

    }

    public function addReply(array $data) // add reply for thread
    {
        // expect array of data "user_id and body of reply"

        $reply = $this->Replies()->create([

            'body' => $data['body'],

            'user_id' => $data['user_id']

        ]);

        // call the ThreadHasNewReply event to execute the listeners

        event(new ThreadHasNewReply($this, $reply));

        // return instance of the added reply

        return $reply;
    }

    public static function addThread(array $data) // create thread
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

    public function scopeFilter($query, $filters)
    {
        // msh 3arf aktb eh bas zay ma 7adrtko shayfen :"D

        return $filters->apply($query);
    }

    public function subscribe($userId = null) // subscribe to thread
    {
        $this->subscribes()

            ->create([

                'user_id' => $userId ?: auth()->id()
            ]);

        // return object of thread

        return $this;
    }

    public function unsubscribe($userId = null)// unsubscribe to thread
    {
        $this->subscribes()

            ->where('user_id', $userId ?: auth()->id())

            ->delete();
    }

    public function subscribes() // create the relationship between subscribes and thread table
    {
        return $this->hasMany('App\subscribe');
    }

    public function getIsSubscribedAttribute() // set the IsSubscribed accessor
    {
        // return bool value if this thread subscribed by authenticated user

        return $this->subscribes()->where('user_id', auth()->id())->exists();
    }

    public function hasUpdatedFor() // check if the thread have updates for authenticated user
    {
        // check if there login user

        if (auth()->check()) {

            $user = auth()->user();

            // return bool value if thread has update for authenticated user by using timestamp

            return $this->updated_at > cache($user->getVistedThreadCasheKey($this));
        }
    }

    public function read()
    {
        // check if user authenticated

        if (auth()->check())

            // save timestamp when user vist the thread in cache

            cache()->forever(auth()->user()->getVistedThreadCasheKey($this), Carbon::now());

        if (!ThreadsVistores::isVisted($this->id, request()->ip()))

            // increment thread views

            ThreadsVistores::incremnt($this, request()->ip());
    }

    public function getRouteKeyName() // override getRouteKeyName to make routes fetch the model binding by column slug not primary key "defualt"
    {
        return 'slug';
    }

    public function setSlugAttribute($value) // set the slug attribute
    {
        $this->attributes['slug'] = str_slug($value) . '-' . $this->id;
    }

    public function markReplyAsBest(Reply $reply) // mark the reply as the best reply for this thread
    {
        $this->update(['best_reply_id' => $reply->id]);
    }

    public function lockToggle() // switch betwen "lock or unlock" the thread
    {
        $this->update(['is_locked' => ! $this->is_locked]);
    }
}
