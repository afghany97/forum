<?php

namespace Tests\Unit;

use Tests\TestCase;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class FavouritesTest extends TestCase
{
    // use DatabaseTransactions to delete all data "thread and reply" after test  

	use DatabaseTransactions;


    /**@test*/

    public function test_login_user_can_favourite_any_reply()
    {
    	// create user and sign in

    	$this->signIn();

    	// create new reply

    	$reply = create('App\Reply');

    	// send post request to test if the favourite record into database

    	$this->post('/replies/' . $reply->id . '/favourite');

		$this->assertCount(1 , $reply->favourites);
    }

    /** @test */

    public function unlogin_user_can_not_favourite_any_reply()
    {
        $this->expectException('Illuminate\Auth\AuthenticationException');

        $reply = create('App\Reply');

        // send post request to test if the favourite record into database

        $this->post('/replies/' . $reply->id . '/favourite');

        $this->assertCount(1 , $reply->favourites);
    }

    /** @test */

    public function login_user_can_favourite_any_thread($value='')
    {
        // create user and sign in

        $this->signIn();

        // create new thread

        $thread = create('App\Thread');

        // send post request to test if the favourite record into database

        $this->post('/threads/' . $thread->id . '/favourite');

        $this->assertCount(1 , $thread->favourites);
    }

     /** @test */

    public function unlogin_user_can_not_favourite_any_thread()
    {
        $this->expectException('Illuminate\Auth\AuthenticationException');

        $thread = create('App\Thread');

        // send post request to test if the favourite record into database

        $this->post('/replies/' . $thread->id . '/favourite');

        $this->assertCount(1 , $thread->favourites);
    }
}
