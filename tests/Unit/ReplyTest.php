<?php

namespace Tests\Unit;

use Tests\TestCase;

use Illuminate\Foundation\Testing\DatabaseMigrations;

use Illuminate\Foundation\Testing\DatabaseTransactions;

use App\Notification\ThreadUpdated;

class ReplyTest extends TestCase
{
	// use DatabaseTransactions to delete all data "thread and reply" after test  

	use DatabaseTransactions;

	public function setUp()
	{
		// call setUp function from parent class to be sure it's executed

		parent::setUp();

		// create a new thread

		$this->thread = create(\App\Thread::class);

		// create a new reply

		$this->reply = create(\App\Reply::class);
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

   /** @test */

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

      $this->signIn();

      // send post request with reply data to store it at database

      $this->post($this->thread->path() . "/replies", $this->reply->toArray());

      // send get request for render thread to test if the reply added successfully
      
      $this->get($this->thread->path())

      ->assertStatus(200)
      
      ->assertSee($this->reply->body);
   }
   
   /**@test*/

   public function test_guest_can_not_delete_reply()
   {
   		$this->expectException('Illuminate\Auth\AuthenticationException');

   		$reply = create('App\Reply');

   		$this->delete("/replies/{$reply->id}")
   			
            ->assertRedirect("/login");
   }
   
   /**@test*/

   public function test_unauthorised_user_can_not_delete_reply()
   {	
   		$this->expectException('Illuminate\Auth\Access\AuthorizationException');

   		$reply = create('App\Reply');

   		$this->signIn()

			->delete("/replies/{$reply->id}")
			
			->assertStatus(403);
   }

   /**@test*/

   public function test_authorised_user_can_delete_reply()
   {
		$this->signIn();

		$reply = create("App\Reply" , ['user_id' => auth()->id()]);

		$this->delete("/replies/{$reply->id}")
			
         ->assertStatus(302);
	}

   /**@test*/

   public function test_unauthorised_user_can_not_update_reply()
   {
      $this->expectException("Illuminate\Auth\Access\AuthorizationException");

      $this->signIn();

      $reply = create("App\Reply");

      $replyBody = "dummy data";

      $this->put("/replies/{$reply->id}" , ['body' => $replyBody])
         
         ->assertStatus(403);
   }

   /**@test*/

   public function test_guest_can_not_update_reply()
   {
      $this->expectException('Illuminate\Auth\AuthenticationException');

      $reply = create('App\Reply');

      $replyBody = "dummy data";

      $this->put("/replies/{$reply->id}" , ['body' => $replyBody])
         
         ->assertRedirect("/login");
   }

   /**@test*/

   public function test_authorised_user_can_update_reply()
   {

      $this->signIn();

      $reply = create("App\Reply" , ['user_id' => auth()->id()]);

      $replyBody = "dummy data";

      $this->put("/replies/{$reply->id}" , ['body' => $replyBody])
         
         ->assertStatus(302)

         ->assertRedirect($reply->path());
   }

   /**@test*/

   public function test_authorised_user_can_see_update_reply_form()
   {
      $this->signIn();

      $reply = create("App\Reply" , ['user_id' => auth()->id()]);

      $this->patch("/replies/{$reply->id}" )
         
         ->assertStatus(200)

         ->assertSee($reply->body);
   }

   /**@test*/

   public function test_unauthorised_user_can_not_see_update_reply_form()
   {
      $this->expectException("Illuminate\Auth\Access\AuthorizationException");

      $this->signIn();

      $reply = create("App\Reply");

      $this->patch("/replies/{$reply->id}" )
         
         ->assertStatus(403)

         ->assertDontSee($reply->body);
   }

    /**@test*/

   public function test_guest_can_not_see_update_reply_form()
   {
      $this->expectException('Illuminate\Auth\AuthenticationException');
      

      $reply = create("App\Reply");

      $this->patch("/replies/{$reply->id}" )
         
         ->assertRedirect('/login');
   }

   /**@test*/

   public function test_user_may_not_add_more_than_one_reply_per_minute()
   {
      $this->signIn();
      
      $this->post($this->thread->path() . "/replies", $this->reply->toArray())
      
            ->assertStatus(302);

      $this->post($this->thread->path() . "/replies", $this->reply->toArray())
      
            ->assertStatus(422);
   }
}
