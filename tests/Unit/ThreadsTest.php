<?php

namespace Tests\Unit;

use Tests\TestCase;

use Illuminate\Foundation\Testing\DatabaseMigrations;

use Illuminate\Foundation\Testing\DatabaseTransactions;

class ThreadsTest extends TestCase
{
    // use DatabaseTransactions to delete all data "thread and reply" after test  

	use DatabaseTransactions;

    public function setup()
    {
        // call setUp function from parent class to be sure it's executed

        parent::setUp();

        // create a new thread

    	$this->thread = factory(\App\Thread::class)->create();
        
    }

    public function test_if_user_can_see_one_thread()
    {
        // send get request to specific thread path to test if user can browse specific thread

    	$this->get($this->thread->path())

        ->assertSee($this->thread->title);
    }

    public function test_if_user_can_see_all_threads()
    {
        // send get request to threads path to test if user can browse all threads

    	$this->get('/threads/')

        ->assertSee($this->thread->title);
    }


    public function test_if_thread_have_replies()
    {
        // test if the thread have replies by test if the return of replies method on thread model instance of collection

        $this->assertInstanceOf('Illuminate\Database\Eloquent\Collection' , $this->thread->Replies);

    }

    public function test_if_thread_have_owner()
    {
        // test if the thread have owner by test if the return of user method on thread model instance of User model

        $this->assertInstanceOf('App\User' , $this->thread->User);
    }

}
