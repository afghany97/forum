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

        ->assertStatus(200)

        ->assertSee($this->thread->title);
    }

    public function test_if_user_can_see_all_threads()
    {
        // send get request to threads path to test if user can browse all threads

    	$this->get('/threads/')

        ->assertStatus(200)

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

    public function test_if_unloogin_user_can_add_thread()
    {
        // expect exception returned from this test 
        
        $this->expectException('Illuminate\Auth\AuthenticationException');

        $thread = factory(\App\Thread::class)->make();

        // send post request with thread data to test if it would be added to database successfully

        $this->post('/threads' , $thread->toArray());

        // send get request to test if the thread appeared to thread page 

        $this->get($thread->path())

        ->assertSee($this->thread->title) // test if the title of new thread in thread page

        ->assertSee($this->thread->body); // test if the body of new thread i
    }

    public function test_if_login_user_can_add_thread()
    {
        // create user and sign in 

        $this->be($user = factory(\App\User::class)->create());

        // create a instance of thread model

        $thread = factory(\App\Thread::class)->make();

        // send post request with thread data to test if it would be added to database successfully

        $this->post('/threads' , $thread->toArray());

        // send get request to test if the thread appeared to thread page 

        $this->get($thread->path())

        ->assertStatus(200)

        ->assertSee($this->thread->title) // test if the title of new thread in thread page

        ->assertSee($this->thread->body); // test if the body of new thread in thread page

    }
}
