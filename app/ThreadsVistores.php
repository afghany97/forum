<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

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
        // check if the ip of visitor already exists

            if (!in_array($vistorIp, static::getVisitoers()))
            {

               self::create([

                    'thread_id' => $thread->id,

                    'vistoer_ip' => $vistorIp,

                   'thread_title' => $thread->title,

                   'thread_path' => $thread->path()
                ]);

                $thread->increment('visits');
            }
    }

    public static function isVisited($thread_id, $ip)
    {
        // check if given thread visited by given ip address

        return !! static::where([['thread_id', $thread_id], ['vistoer_ip', $ip]])->count();
    }
}
