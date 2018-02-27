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
    	$this->signIn();

    	$thread = create('App\Thread')->subscribe();

    	$user = auth()->user();

    	$this->assertCount(0 , $user->notifications);

    	$thread->addReply([

    		'user_id' => auth()->id(),

    		'body' => 'dummy reply data'
    	]);
    	
    	$this->assertCount(0 , $user->fresh()->notifications);

    	$thread->addReply([

    		'user_id' => create('App\User')->id,

    		'body' => 'dummy reply data'
    	]);

    	$this->assertCount(1, $user->fresh()->notifications);
    }

    /** @test */

    public function a_user_can_mark_a_notification_as_read()
    {
		$this->signIn();

    	$thread = create('App\Thread')->subscribe();

    	$user = auth()->user();

    	$thread->addReply([

    		'user_id' => create('App\User')->id,

    		'body' => 'dummy reply data'
    	]);

    	$this->assertCount(1, $user->fresh()->unreadNotifications);

    	$notificationId = $user->unreadNotifications->first()->id;

    	$this->delete("/profiles/{$user->name}/notifications/{$notificationId}");

    	$this->assertCount(0 , $user->fresh()->unreadNotifications);
    }

     /** @test */

     public function user_can_fetch_all_notifications()
     {
     	$this->signIn();

    	$thread = create('App\Thread')->subscribe();

    	$user = auth()->user();

    	$thread->addReply([

    		'user_id' => create('App\User')->id,

    		'body' => 'dummy reply data'
    	]);

    	$this->get("/profiles/{$user->name}/notifications");

    	$this->assertCount(1,$user->notifications);
     }
}
