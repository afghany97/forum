<?php

namespace Tests\Unit;

use Tests\TestCase;

use Illuminate\Foundation\Testing\DatabaseMigrations;

use Illuminate\Foundation\Testing\DatabaseTransactions;

class ThreadsTest extends TestCase
{
	use DatabaseTransactions;

    public function setup()
    {
        parent::setUp();

    	$this->thread = factory(\App\Thread::class)->create();
        
    }

    public function test_if_user_can_see_one_thread()
    {

    	$responce = $this->get('/threads/' . $this->thread->id);

        $responce->assertSee($this->thread->title);
    }

    public function test_if_user_can_see_all_threads()
    {

    	$responce = $this->get('/threads/');

        $responce->assertSee($this->thread->title);
    }
}
