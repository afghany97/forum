<?php

namespace Tests\Unit;

use Tests\TestCase;

use Illuminate\Foundation\Testing\DatabaseMigrations;

use Illuminate\Foundation\Testing\DatabaseTransactions;

class ReplyTest extends TestCase
{
	// use DatabaseTransactions to delete all data "thread and reply" after test  

	use DatabaseTransactions;

	public function setUp()
	{
		// call setUp function from parent class to be sure it's executed

		parent::setUp();

		// create a new thread

		$this->thread = factory(\App\Thread::class)->create();

		// create a new reply

		$this->reply = factory(\App\Reply::class)->create();
	}

	public function test_if_user_can_see_replies()
	{
   		// send get request for render thread to test if the user can browse the replies

		$this->get($this->reply->Thread->path())

		->assertStatus(200)
		
		->assertSee($this->reply->body);
		
	}

	public function test_add_reply()
	{
		// call addReply method 	

		$reply = $this->thread->addReply([
		
			'body' => 'test',
		
			'user_id' => 999
		
		]);

		// test if the reply add successfully

		$this->assertEquals($this->thread->id,$reply->Thread->id);
	}

   public function test_if_unlogin_user_can_submit_add_reply_form()
   {
   		// expect exception returned from this test 
        
        $this->expectException('Illuminate\Auth\AuthenticationException');

   		// send post request with reply data to store it at database

   		$this->post($this->thread->path() . "/replies", $this->reply->toArray());

   		// send get request for render thread to test if the reply added successfully
   		
   		$this->get($this->thread->path())

   		->assertStatus(200)
   		
   		->assertSee($this->reply->body);
   }

   public function test_if_login_user_can_submit_add_reply_form()
   {
   		// create user and sign in 
   		
   		$this->be($user = factory(\App\User::class)->create());

   		// send post request with reply data to store it at database

   		$this->post($this->thread->path() . "/replies", $this->reply->toArray());

   		// send get request for render thread to test if the reply added successfully
   		
   		$this->get($this->thread->path())

   		->assertStatus(200)
   		
   		->assertSee($this->reply->body);
   }
}
