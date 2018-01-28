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

    	$this->get($this->thread->path())

        ->assertSee($this->thread->title);
    }

    public function test_if_user_can_see_all_threads()
    {

    	$this->get('/threads/')

        ->assertSee($this->thread->title);
    }
}
