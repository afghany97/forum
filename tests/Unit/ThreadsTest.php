<?php

namespace Tests\Unit;

use Tests\TestCase;

use Illuminate\Foundation\Testing\DatabaseMigrations;

use Illuminate\Foundation\Testing\DatabaseTransactions;

class ThreadsTest extends TestCase
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

    public function test_if_user_can_see_one_thread()
    {
        // send get request to specific thread path to test if user can browse specific thread

    	$this->get($this->thread->path())

        ->assertStatus(200)

        ->assertSee($this->thread->title);
    }

    public function test_if_user_can_see_all_threads()
    {
        // send get request to threads path to test if user can browse all threads

    	$this->get('/threads/')

        ->assertStatus(200)

        ->assertSee($this->thread->title);
    }


    public function test_if_thread_have_replies()
    {
        // test if the thread have replies by test if the return of replies method on thread model instance of collection

        $this->assertInstanceOf('Illuminate\Database\Eloquent\Collection' , $this->thread->Replies);

    }

    public function test_if_thread_have_owner()
    {
        // test if the thread have owner by test if the return of user method on thread model instance of User model

        $this->assertInstanceOf('App\User' , $this->thread->User);
    }

    public function test_if_unloogin_user_can_add_thread()
    {
        // expect exception returned from this test 
        
        $this->expectException('Illuminate\Auth\AuthenticationException');


        // send post request with thread data to test if it would be added to database successfully

        $this->post('/threads' , $this->thread->toArray());

        // send get request to test if the thread appeared to thread page 

        $this->get($this->$thread->path())

        ->assertSee($this->thread->title) // test if the title of new thread in thread page

        ->assertSee($this->thread->body); // test if the body of new thread i
    }

    public function test_if_login_user_can_add_thread()
    {
        // create user and sign in 

        $this->signIn(create(\App\User::class));

        // make a instance of thread class

        $thread = make(\App\Thread::class);

        // send post request with thread data to test if it would be added to database successfully

        $respone = $this->post('/threads' , $thread->toArray());

        // send get request to test if the thread appeared to thread page 

        $this->get($respone->headers->get('location'))

        ->assertStatus(200)

        ->assertSee($thread->title) // test if the title of new thread in thread page

        ->assertSee($thread->body); // test if the body of new thread in thread page

    }

    public function test_if_user_can_see_threads_for_each_channel()
    {
        // create new channl

        $channel = create('App\Channel');

        // create new thread for previous channel

        $threadInChannel = create('App\Thread' , ['channel_id' => $channel->id]);

        // create new thread out of previous channel 

        $threadOutChannel = $this->thread;

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
        $this->expectException('Illuminate\Auth\AuthenticationException');

        $this->delete($this->thread->path())

            ->assertRedirect('/login');
    }

    /**@test*/
    
    public function test_if_unauthorised_user_cannot_delete_threads()
    {
        $this->expectException('Illuminate\Auth\Access\AuthorizationException');

        $this->signIn();

        $this->delete($this->thread->path())

            ->assertSee('This action is unauthorized');
    }

    // subscribes tests

    /**@test*/

    public function test_if_user_can_subscribe_thread()
    {
        $thread = create('App\Thread');

        $this->signIn();

        $thread->subscribe();

        $this->assertEquals(1,$thread->subscribes->where('user_id',auth()->id())->count());
    }

    /**@test*/

    public function test_if_user_can_unsubscribe_thread()
    {
        $thread = create('App\Thread');

        $this->signIn();

        $thread->subscribe();

        $thread->unsubscribe();

        $this->assertCount(0 , $thread->subscribes);
    }

    /**@test*/

    public function test_if_user_can_subscribe_thread_form()
    {
        $this->signIn();

        $thread = create('App\Thread');

        $this->post($thread->path() . '/subscribe');

        $this->assertCount(1 , $thread->subscribes);
    }

    /**@test*/

    public function test_if_user_can_unsubscribe_thread_form()
    {
        $this->signIn();

        $thread = create('App\Thread');

        $this->delete($thread->path() . '/subscribe');

        $this->assertCount(0 , $thread->subscribes);
    }

    // public function test_if_user_can_filter_threads_by_populair()
    // {
    //     // create thread and create 3 replies for this thread

    //     $threadswith3replies = create('App\Thread'); 

    //     create('App\Reply',['thread_id' =>$threadswith3replies->id] , 3);
        
    //     // create thread and create 2 replies for this thread

    //     $threadswith2replies = create('App\Thread'); 
        
    //     create('App\Reply',['thread_id' =>$threadswith2replies->id] , 2);

    //     // create thread witout replies

    //     $threadswithnoreplies = $this->thread; 

    //     // get request for threads filtered by Popularity

    //     $respone = $this->getJson('/threads?populair=1')->json();

    //     $this->assertEquals([3,2,0],array_column($respone, 'replies_count'));
    // }
}
