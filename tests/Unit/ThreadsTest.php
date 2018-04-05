<?php

namespace Tests\Unit;

use Tests\TestCase;

use Illuminate\Foundation\Testing\DatabaseMigrations;

use Illuminate\Foundation\Testing\DatabaseTransactions;

class ThreadsTest extends TestCase
{
    // use DatabaseTransactions to delete all data "thread and reply" after test  

	use DatabaseTransactions;


    public function test_if_user_can_see_one_thread()
    {
        // create thread

        $thread = create('App\Thread');

        // send get request to specific thread path to test if user can browse specific thread

    	$this->get($thread->path())

        ->assertStatus(200)

        ->assertSee($thread->title);
    }

    public function test_if_user_can_see_all_threads()
    {
        // create thread

        $thread = create('App\Thread');

        // send get request to threads path to test if user can browse all threads

    	$this->get('/threads/')

        ->assertStatus(200)

        ->assertSee($thread->title);
    }


    public function test_if_thread_have_replies()
    {
        // create thread

        $thread = create('App\Thread');

        // test if the thread have replies by test if the return of replies method on thread model instance of collection

        $this->assertInstanceOf('Illuminate\Database\Eloquent\Collection' , $thread->Replies);
    }

    public function test_if_thread_have_owner()
    {
        // create thread

        $thread = create('App\Thread');

        // test if the thread have owner by test if the return of user method on thread model instance of User model

        $this->assertInstanceOf('App\User' , $thread->User);
    }

    public function test_if_un_login_user_can_not_add_thread()
    {
        // create thread

        $thread = create('App\Thread');

        // expect exception returned from this test 
        
        $this->expectException('Illuminate\Auth\AuthenticationException');

        // send post request with thread data to test if it would be added to database successfully

        $this->post('/threads' , $thread->toArray());
    }

    public function test_if_login_user_and_confirmed_can_add_thread()
    {
        // create user and sign in and confirm

        $this->signIn($user = create('App\User'))->confirm($user);

        $thread = create('App\Thread');

        // check if user confirmed

        $this->assertTrue($user->fresh()->confirmed);

        // send post request with thread data to test if it would be added to database successfully

        $this->post('/threads',$thread->toArray());

        // send get request to test if the thread appeared to thread page

        $this->get($thread->path())

        ->assertStatus(200)

        ->assertSee($thread->title) // test if the title of new thread in thread page

        ->assertSee($thread->body); // test if the body of new thread in thread page
    }

    public function test_if_user_can_see_threads_for_each_channel()
    {
        // create new channel

        $channel = create('App\Channel');

        // create new thread for previous channel

        $threadInChannel = create('App\Thread' , ['channel_id' => $channel->id]);

        // create new thread out of previous channel

        $threadOutChannel = create('App\Thread');

        // send get request for channel page to test if the the threads that belong to the channel appeared

        $this->get('/threads/' . $channel->name)

        ->assertSee($threadInChannel->title)

        ->assertDontSee($threadOutChannel->title);
    }

    public function test_if_user_can_filter_threads_by_user()
    {
        // create user and sign in 

        $this->signIn(create(\App\User::class));
        
        // create thread by login user

        $threadbyuser = create('App\Thread',['user_id' => auth()->id()]);

        // create thread by other user

        $threadnotbyuser = create('App\Thread');

        // send get request for threads filtered by username

        $this->get('/threads?by=' . auth()->user()->name)

        ->assertSee($threadbyuser->title)

        ->assertDontSee($threadnotbyuser->title);    
    }

    /**@test*/

    public function test_if_authorised_user_can_delete_thread()
    {
        // create user and sign in

        $this->signIn($user = create('App\User'));

        // create thread belong to user

        $thread = create('App\Thread' , ['user_id' => $user->id]);

        // send delete request for the end point

        $this->delete($thread->path())

            ->assertRedirect('/threads')

            ->assertDontSee($thread->title);
    }

    /**@test*/
    
    public function test_if_guest_cannot_delete_threads()
    {
        // create thread

        $thread = create('App\Thread');

        // this test expect AuthenticationException

        $this->expectException('Illuminate\Auth\AuthenticationException');

        // send delete request to delete thread end point

        $this->delete($thread->path())
            
            // expect redirect to login page

            ->assertRedirect('/login');
    }

    /**@test*/
    
    public function test_if_unauthorised_user_cannot_delete_threads()
    {
        // create thread

        $thread = create('App\Thread');

        // this test expect AuthorizationException
        
        $this->expectException('Illuminate\Auth\Access\AuthorizationException');

        // create user and sign in

        $this->signIn();

        // send delete request to delete thread end point

        $this->delete($thread->path())

            // expect see This action is unauthorized 

            ->assertSee('This action is unauthorized');
    }

    // subscribes tests

    /**@test*/

    public function test_if_user_can_subscribe_thread()
    {
        // create thread

        $thread = create('App\Thread');

        // create user and sign in

        $this->signIn();

        // subscribe thread by authenticated user

        $thread->subscribe();

        // expect authenticated user subscribes equals first param 

        $this->assertEquals(1,$thread->subscribes->where('user_id',auth()->id())->count());
    }

    /**@test*/

    public function test_if_user_can_unsubscribe_thread()
    {
        // create thread

        $thread = create('App\Thread');

        // create user and sign in

        $this->signIn();

        // subscribe thread by authenticated user
        
        $thread->subscribe();

        // unsubscribe thread by authenticated user

        $thread->unsubscribe();

        // expect authenticated user subscribes equals 0 

        $this->assertCount(0 , $thread->subscribes);
    }

    /**@test*/

    public function test_if_user_can_subscribe_thread_form()
    {
        // create user and sign in

        $this->signIn();

        // create thread

        $thread = create('App\Thread');

        // send post request to thread subscribe end point

        $this->post($thread->path() . '/subscribe');

        // expect thread subscribes equal 1

        $this->assertCount(1 , $thread->subscribes);
    }

    /**@test*/

    public function test_if_user_can_unsubscribe_thread_form()
    {
        // create user and sign in

        $this->signIn();

        // create thread

        $thread = create('App\Thread');

        // send delete request to thread subscribe end point

        $this->delete($thread->path() . '/subscribe');

        // expect thread subscribes equal 0
        
        $this->assertCount(0 , $thread->subscribes);
    }


    /** @test */

    public function test_if_login_user_got_update_for_new_threads()
    {
        // create user and sign in
        
        $this->signIn();

        // create thread
        
        $thread = create('App\Thread');

        // check if user didn't vist this thread  "has updated for authenticated user"
        
        $this->assertTrue($thread->hasUpdatedFor());

        // send get request to thread end point "vist the thread by authenticated user"

        $this->get('/threads/' . $thread->Channel->name . '/' . $thread->id);

        // send get request to all threads end point
    
        $this->get('/threads/');

        // check if user vist this thread  "don't have updated for authenticated user"
        
        $this->assertFalse($thread->hasUpdatedFor());
    }

    /** @test */

    public function test_if_login_user_got_update_after_add_new_reply()
    {
        // create user and sign in
        
        $this->signIn();

        // create thread

        $thread = create('App\Thread');

        // add reply belogn to other user

        $thread->addReply([

            'body' =>  'dummy data',

            'user_id' => create('App\User')->id
        ]);

        // expcet thread has updates for authenticated user
         
        $this->assertTrue($thread->hasUpdatedFor());
    }

    /** @test */

    public function notify_all_subscribers_after_update_thread()
    {
        // create user "ahmed" and sign in

        $this->signIn($ahmed = create('App\User',['name' => 'ahmed']));

        // create user "mo" and sign in and confirm

        $this->signIn($mo = create('App\User',['name'=>'muhammad']))->confirm($mo);

        // create channel

        $channel = create('App\Channel');

        // create thread by mo

        $thread = create('App\Thread',['user_id' => $mo->id , 'channel_id' => $channel->id]);

        // let ahmed subscribe mo thread

        $thread->subscribe($ahmed->id);

        // check ahmed notifications

        $this->assertCount(0,$ahmed->notifications);

        // let mo update his thread

        $this->put("/threads/{$channel->name}/{$thread->id}/update",[
            'channel_id' => create($channel = 'App\Channel')->id,
            'title' => 'update',
            'body' => 'update'
        ]);

        // check ahmed notifications

        $this->assertCount(1,$ahmed->fresh()->notifications);
    }
    /** @test */

    // public function test_if_user_can_filter_threads_by_populair()
    // {
    //     // create thread and create 3 replies for this thread

    //     $threadswith3replies = create('App\Thread');

    //     create('App\Reply',['thread_id' =>$threadswith3replies->id] , 3);
        
    //     // create thread and create 2 replies for this thread

    //     $threadswith2replies = create('App\Thread');
        
    //     create('App\Reply',['thread_id' =>$threadswith2replies->id] , 2);

    //     // create thread witout replies

    //     $threadswithnoreplies = $thread;

    //     // get request for threads filtered by Popularity

    //     $respone = $this->getJson("/threads?populair=1")->json();

    //     $this->assertEquals([3,2,0],array_column($respone, 'replies_count'));
    // }
}
