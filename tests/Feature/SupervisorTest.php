<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class SupervisorTest extends TestCase
{
    use DatabaseTransactions;

    /** @test */

    public function supervisor_can_lock_any_thread()
    {
        // create user "supervisor" and sign in

        $this->signIn($user = create('App\User',['is_supervisor' => true]));

        // create thread

        $thread = create('App\Thread');

        // send put request to lock thread endpoint

        $this->put("/threads/{$thread->slug}/lock");

        // check if thread locked

        $this->assertTrue($thread->fresh()->is_locked);
    }

    /** @test */

    public function unsupervisor_can_not_lock_any_thread()
    {
        // create user "un-supervisor" and sign in

        $this->signIn($user = create('App\User'));

        // create thread

        $thread = create('App\Thread');

        // send put request to lock thread endpoint

        $this->put("/threads/{$thread->slug}/lock")

            // check if user see the error msg

            ->assertSee('action not allowed')

            // check if response status 401 "UNAUTHORIZED"

            ->assertStatus(401);

        // check if thread not locked

        $this->assertFalse($thread->fresh()->is_locked);
    }

    /** @test */

    public function thread_owner_got_notification_when_supervisor_lock_his_thread()
    {
        // create user and sign in and confirm

        $this->signIn($user = create('App\User'))->confirm($user);

        // create thread belongs to user

        $thread = create('App\Thread' , ['user_id' => auth()->id()]);

        // sign in supervisor user

        $this->signIn(create('App\User' , ['is_supervisor' => true]));

        // send put request to thread lock endpoint

        $this->put("/threads/{$thread->slug}/lock");

        // check if thread locked

        $this->assertTrue($thread->fresh()->is_locked);

        // check if thread owner got notification

        $this->assertCount(1,$user->notifications);

    }

}
