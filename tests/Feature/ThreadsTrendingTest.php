<?php

namespace Tests\Feature;

use App\ThreadsVistores;
use Tests\TestCase;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class ThreadsTrendingTest extends TestCase
{
    use DatabaseTransactions;

    /** @test */

    public function test_threads_trending()
    {
        $thread = create('App\Thread');

        foreach (range(0,4) as $i)
        {
            $ip = mt_rand(0, 255) . '.' .mt_rand(0, 255) . '.' .mt_rand(0, 255) . '.' .mt_rand(0, 255);

            $this->call('get', $thread->path(), ['data'=>'value'], [], [], ['REMOTE_ADDR' => $ip]);
        }

        $array = ThreadsVistores::fetchTopTrendingThreads(1000)->pluck('trend')->toArray();

        $lastElement = array_values(array_slice($array, -1))[0];

        $this->assertEquals(5,$lastElement);
    }
}
