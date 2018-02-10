<?php

namespace Tests\Unit;

use Tests\TestCase;

use Illuminate\Foundation\Testing\DatabaseMigrations;

use Illuminate\Foundation\Testing\DatabaseTransactions;

class FavouriteTest extends TestCase
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
    }

	// public function test_if_login_user_can_favourite_any_reply()
	// {
	// 	// create user and singin

 //        $this->signIn(create(\App\User::class));

	// 	// create new reply

	// 	$reply = $this->reply;

	// 	// send post request to add favorite to reply 
	// 	$this->post('replies/' . $reply->id . '/favourite')

	// 	->assertCount(1,$reply->favourites->count());
	// }

}