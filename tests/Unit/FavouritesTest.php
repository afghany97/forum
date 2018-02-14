<?php

namespace Tests\Unit;

use Tests\TestCase;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class FavouritesTest extends TestCase
{
    // use DatabaseTransactions to delete all data "thread and reply" after test  

	use DatabaseTransactions;

    public function setup()
    {
        // call setUp function from parent class to be sure it's executed

        parent::setUp();

        // create a new thread

    	$this->thread = create(\App\Thread::class);
    }

    /**@test*/

    // public function test_login_user_can_favourite_any_reply()
    // {
    // 	// create user and sign in

    // 	$this->signIn();

    // 	// create new reply

    // 	$reply = create('App\Reply');

    // 	// send post request to test if the favourite record into database

    // 	$this->post('/replies/' . $reply->id . '/favourite')

    // 		->assertCount(1 , $reply->favourites->count());
    // }
}
