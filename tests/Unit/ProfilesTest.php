<?php

namespace Tests\Unit;

use Tests\TestCase;

use Illuminate\Foundation\Testing\DatabaseMigrations;

use Illuminate\Foundation\Testing\DatabaseTransactions;

class ProfilesTest extends TestCase
{
	// use DatabaseTransactions to delete all data "thread and reply" after test  

	use DatabaseTransactions;

	public function setup()
    {
        // call setUp function from parent class to be sure it's executed

        parent::setUp();

        // create a new thread

    	$this->thread = create(\App\Thread::class);

    	// create new reply

    	$this->reply = create(\App\Reply::class);

        // create new user

        $this->user = create(\App\User::class);
    }

    public function test_if_user_threads_appears_in_his_profile()
    {
        // create user and sign in

        $this->signIn();

        // create thread belongs to authenticated user

        $thread = create('App\Thread' , ['user_id' => auth()->id()]);

        // send get request for user profile 
        
        $this->get('profiles/' . auth()->user()->name)

            ->assertSee($thread->title) // check if the thread title appears in response

            ->assertSee($thread->body); // check if the thread body appears in response
    }
}