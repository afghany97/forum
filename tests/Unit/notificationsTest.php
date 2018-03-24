<?php

namespace Tests\Unit;

use Tests\TestCase;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class notificationsTest extends TestCase
{

    use DatabaseTransactions;

    /**@test*/

    public function test_if_user_got_notify_after_add_new_reply_from_other_users_on_subscribed_thread()
    {
		// create user and sign in

    	$this->signIn();

		// create thread and subscribe by authenticated user

    	$thread = create('App\Thread')->subscribe();

    	$user = auth()->user();

		// check if authenticated user have 0 notifications

    	$this->assertCount(0 , $user->notifications);

		// add reply to thread by authenticated user

    	$thread->addReply([

    		'user_id' => auth()->id(),

    		'body' => 'dummy reply data'
    	]);
    	
		// check if authenticated user still have 0 notifications

    	$this->assertCount(0 , $user->fresh()->notifications);

		// add repyl to thread by other user

    	$thread->addReply([

    		'user_id' => create('App\User')->id,

    		'body' => 'dummy reply data'
    	]);

		// check if authenticated user got new notification

		$this->assertCount(1, $user->fresh()->notifications);
    }

    /** @test */

    public function a_user_can_mark_a_notification_as_read()
    {
		// create user and sign in

		$this->signIn();

		// create thread and subscribe by authenticated user

    	$thread = create('App\Thread')->subscribe();

    	$user = auth()->user();

		// add reply to thread by other user

    	$thread->addReply([

    		'user_id' => create('App\User')->id,

    		'body' => 'dummy reply data'
    	]);

		// check if authenticated user got notification

    	$this->assertCount(1, $user->fresh()->unreadNotifications);

		// fetch first notification id 

    	$notificationId = $user->unreadNotifications->first()->id;

		// send delete request to mark first notification as read

    	$this->delete("/profiles/{$user->name}/notifications/{$notificationId}");

		// check if authenticated user have 0 unread notifications

    	$this->assertCount(0 , $user->fresh()->unreadNotifications);
    }

     /** @test */

     public function user_can_fetch_all_notifications()
     {
		// create user and sign in

     	$this->signIn();

		// create thread and subscribe by authenticated user

    	$thread = create('App\Thread')->subscribe();

    	$user = auth()->user();

		// add reply by other user
    	
		$thread->addReply([

    		'user_id' => create('App\User')->id,

    		'body' => 'dummy reply data'
    	]);
		
		// send get request to all user notifications

		$this->get("/profiles/{$user->name}/notifications");

		// check if authenticated user got notification

    	$this->assertCount(1,$user->notifications);
     }
}
