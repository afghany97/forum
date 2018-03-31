<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ThreadsVistores extends Model
{
    protected $table = "trendings";

    protected $guarded = [];

    public static function getVistoers()
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

        $threadVists = static::selectRaw("COUNT(*) as trend , thread_id as id")
            ->where('thread_id', $thread_id)
            ->groupBy("thread_id")
            ->get();

        cache()->forever(static::cacheKey($thread_id), $threadVists[0]->trend);
    }

    public static function fetchTopTrendingThreads($take = 5)
    {
        return static::sort(static::selectRaw("COUNT(*) as trend , thread_id as id")

            ->groupBy("thread_id")

            ->orderByRaw("'trend' DESC")

            ->take($take)

            ->get()->toArray());
    }

    private static function sort($array)
    {
        for ($i = 0; $i < count($array) - 1 - 1; $i++) {

            for ($j = 0; $j < count($array) - 1 - 1 - $i; $j++) {

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
        return !!static::where([['thread_id', $thread_id], ['vistoer_ip', $ip]])->count();
    }

    public static function ThreadVists($thread)
    {
        return static::selectRaw("COUNT(*) as trend , thread_id as id")
            ->where('thread_id', $thread->id)
            ->groupBy("thread_id")
            ->get();
    }

    public static function cacheKey($thread_id)
    {
        return sprintf("thread-%s-vistis", $thread_id);
    }
}
