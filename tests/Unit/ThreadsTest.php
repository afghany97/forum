<?php

namespace Tests\Unit;

use Tests\TestCase;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class ThreadsTest extends TestCase
{
	use DatabaseTransactions;

    public function test_if_user_can_see_one_thread()
    {
    	$thread = factory(\App\Thread::class)->create();

    	$responce = $this->get('/threads/' . $thread->id);

        $responce->assertSee($thread->title);
    }
    public function test_if_user_can_see_all_threads()
    {
    	$thread = factory(\App\Thread::class)->create();

    	$responce = $this->get('/threads/');

        $responce->assertSee($thread->title);
    }
}
