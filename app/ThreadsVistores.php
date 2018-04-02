<?php

namespace App;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Cache;

class ThreadsVistores extends Model
{
    protected $table = "trendings";

    protected $guarded = [];

    private static function getVistoers()
    {
        return static::all()->toArray();
    }

    public static function incremnt($thread_id, $vistorIp)
    {
        if (!in_array($vistorIp, static::getVistoers()))

            static::create([

                'thread_id' => $thread_id,

                'vistoer_ip' => $vistorIp
            ]);
    }

    public static function fetchTopTrendingThreads($take = 5)
    {
        if(cache(static::trendingCacheKey()))

            return cache(static::trendingCacheKey());

        $topTrendingThreads = static::sort(static::selectRaw("COUNT(*) as trend , thread_id as id")

            ->groupBy("thread_id")

            ->orderByRaw("'trend' DESC")

            ->take($take)

            ->get()->toArray());

        self::saveTrendingThreadsToCache($topTrendingThreads);

        return $topTrendingThreads;
    }

    private static function sort($array)
    {
        for ($i = 0; $i < count($array) - 2; $i++) {

            for ($j = 0; $j < count($array) - 2 - $i; $j++) {

                if ($array[$j]['trend'] < $array[$j + 1]['trend']) {

                    $temp = $array[$j];

                    $array[$j] = $array[$j + 1];

                    $array[$j + 1] = $temp;
                }
            }
        }

        return $array;
    }

    public static function isVisted($thread_id, $ip)
    {
        return !! static::where([['thread_id', $thread_id], ['vistoer_ip', $ip]])->count();
    }

    public static function ThreadVists($thread)
    {
        if(cache(static::vistsCacheKey($thread->id)))
        {
            return cache(static::vistsCacheKey($thread->id));
        }
        $threadVists = static::selectRaw("COUNT(*) as trend , thread_id as id")
            ->where('thread_id', $thread->id)
            ->groupBy("thread_id")
            ->get();

        self::saveThreadsVistsToCache($thread, $threadVists);

        return $threadVists;
    }

    private static function trendingCacheKey()
    {
        return "trendingThreads";
    }

    private static function vistsCacheKey($thread_id)
    {
        return sprintf("thread-%s-vistis", $thread_id);
    }

    private static function saveThreadsVistsToCache($thread, $threadVists)
    {
        count($threadVists) ? cache::put(static::vistsCacheKey($thread->id), $threadVists[0]->trend, Carbon::now()->addMinute(30)) : cache::put(static::vistsCacheKey($thread->id), 0, Carbon::now()->addMinute(30));
    }

    /**
     * @param $topTrendingThreads
     */
    private static function saveTrendingThreadsToCache($topTrendingThreads)
    {
        count($topTrendingThreads) ? cache::put(static::trendingCacheKey(), $topTrendingThreads, Carbon::now()->addMinute(10)) : cache::put(static::trendingCacheKey(), 0, Carbon::now()->addMinute(10));
    }
}
