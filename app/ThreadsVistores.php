<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ThreadsVistores extends Model
{
    protected  $table = "trendings";

    protected $guarded = [];

    public static function getVistoers()
    {
        return static::all()->toArray();
    }

    public static function incremnt($thread_id, $vistorIp)
    {
        if(! in_array($vistorIp,static::getVistoers()))

            static::create([

                'thread_id' => $thread_id,

                'vistoer_ip' => $vistorIp
            ]);
    }

    public static function fetchTopTrendingThreads($take = 5)
    {
        return static::selectRaw("COUNT(*) as trend , thread_id as id")

            ->groupBy("thread_id")

            ->take($take)

            ->get();
    }

    public static function isVisted($thread_id ,$ip)
    {
        return !! static::where([['thread_id' , $thread_id] , ['vistoer_ip' , $ip]])->count();
    }
}
