<?php

namespace App;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;

class ThreadsVistores extends Model
{
    protected $table = "trendings";

    protected $guarded = [];

    private static function getVisitoers()
    {
        // return the visitors and convert to array

        return static::all()->toArray();
    }

    public static function incremnt($thread, $vistorIp) // add visitor to thread
    {
        // check if the ip of visitor already existis

        if (!in_array($vistorIp, static::getVisitoers()))

           self::create([

                'thread_id' => $thread->id,

                'vistoer_ip' => $vistorIp,

               'thread_title' => $thread->title,

               'thread_path' => $thread->path()
            ]);
    }

    public static function fetchTopTrendingThreads($take = 5) // fetch top threads order by number of visits
    {
        return static::selectRaw("COUNT(*) as trend , thread_title as title , thread_path as path")

            ->groupBy(['thread_id','thread_title','thread_path'])

            ->orderByRaw("trend DESC")

            ->take($take)

            ->get()

            ->toArray();
    }

    public static function isVisted($thread_id, $ip)
    {
        // check if given thread visited by given ip address

        return !! static::where([['thread_id', $thread_id], ['vistoer_ip', $ip]])->count();
    }

    public static function ThreadVists($thread) // return the number of visits for given thread
    {
        // check if the number of the visits in cache

        if(cache(static::cacheKey($thread->id)))
        {
            // return if exists

            return cache(static::cacheKey($thread->id));
        }

        // fetch the number of vists for given thread "query"

        $threadVists = static::selectRaw("COUNT(*) as trend , thread_id as id")

            ->where('thread_id', $thread->id)

            ->groupBy("thread_id")

            ->get();

        // save the result of query to cache

        self::saveToCache($thread, $threadVists);

        // return the thread visits number

        return $threadVists;
    }

    private static function cacheKey($thread_id)
    {
        // return the format of cache key

        return sprintf("thread-%s-vistis", $thread_id);
    }

    private static function saveToCache($thread, $threadVists)
    {
        // check if the given thread have visits and save to the cache for 30 min , if not save it for 0 not null value

        count($threadVists) ? cache::put(static::cacheKey($thread->id), $threadVists[0]->trend, Carbon::now()->addMinute(30)) : cache::put(static::cacheKey($thread->id), 0, Carbon::now()->addMinute(30));
    }
}
