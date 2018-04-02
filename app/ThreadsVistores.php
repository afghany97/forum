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

    private static function getVistoers()
    {
        return static::all()->toArray();
    }

    public static function incremnt($thread, $vistorIp)
    {
        if (!in_array($vistorIp, static::getVistoers()))

           self::create([

                'thread_id' => $thread->id,

                'vistoer_ip' => $vistorIp,

               'thread_title' => $thread->title,

               'thread_path' => $thread->path()
            ]);
    }

    public static function fetchTopTrendingThreads($take = 5)
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
        return !! static::where([['thread_id', $thread_id], ['vistoer_ip', $ip]])->count();
    }

    public static function ThreadVists($thread)
    {
        if(cache(static::cacheKey($thread->id)))
        {
            return cache(static::cacheKey($thread->id));
        }
        $threadVists = static::selectRaw("COUNT(*) as trend , thread_id as id")
            ->where('thread_id', $thread->id)
            ->groupBy("thread_id")
            ->get();

        self::saveToCache($thread, $threadVists);

        return $threadVists;
    }

    private static function cacheKey($thread_id)
    {
        return sprintf("thread-%s-vistis", $thread_id);
    }

    private static function saveToCache($thread, $threadVists)
    {
        count($threadVists) ? cache::put(static::cacheKey($thread->id), $threadVists[0]->trend, Carbon::now()->addMinute(30)) : cache::put(static::cacheKey($thread->id), 0, Carbon::now()->addMinute(30));
    }
}
