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

        // create thread belongs for specific user

        $thread = create('App\Thread' , ['user_id' => auth()->id()]);

        // send get request for user profile to test if his threads appears
        
        $this->get('profile/' . auth()->user()->name)

            ->assertSee($thread->title)

            ->assertSee($thread->body);
    }
}