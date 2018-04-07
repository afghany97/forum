<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class BestReplyTest extends TestCase
{
    /** @test */

    public function authorize_user_can_select_best_reply()
    {
        // create user and signin and confirm

        $this->signIn($user = create('App\User'))->confirm($user);

        // create thread belongs to authenticated user

        $thread = create('App\Thread',['user_id' => auth()->id()]);

        // create reply belongs to authenticated user and previous thread

        $reply = create('App\Reply',['user_id' => auth()->id() , 'thread_id' => $thread->id]);

        // check if reply mark as best

        $this->assertFalse($reply->isBest);

        // send post request to mark reply as best endpoint

        $this->post("/replies/{$reply->id}/best");

        // check if reply mark as best

        $this->assertTrue($reply->fresh()->isBest);
    }

    /** @test */

    public function unauthorize_user_can_not_select_best_reply()
    {
        // this test expect AuthorizationException

        $this->expectException("Illuminate\Auth\Access\AuthorizationException");

        // create user and signin and confirm

        $this->signIn($user = create('App\User'))->confirm($user);

        // create thread belongs to authenticated user

        $thread = create('App\Thread',['user_id' => $otherUserId = create('App\User')->id]);

        // create reply belongs to authenticated user and previous thread

        $reply = create('App\Reply',['user_id' => $otherUserId , 'thread_id' => $thread->id]);

        // check if reply mark as best

        $this->assertFalse($reply->isBest);

        // send post request to mark reply as best endpoint

        $this->post("/replies/{$reply->id}/best");

        // check if reply mark as best

        $this->assertTrue($reply->fresh()->isBest);

    }

    /** @test */

    public function when_delete_best_reply_update_thread_best_reply_id_column()
    {
        // create user and signin and confirm

        $this->signIn($user = create('App\User'))->confirm($user);

        // create thread belongs to authenticated user

        $thread = create('App\Thread',['user_id' => auth()->id()]);

        // create reply belongs to authenticated user and previous thread

        $reply = create('App\Reply',['user_id' => auth()->id() , 'thread_id' => $thread->id]);

        // check if reply mark as best

        $this->assertFalse($reply->isBest);

        // send post request to mark reply as best endpoint

        $this->post("/replies/{$reply->id}/best");

        // check if reply mark as best

        $this->assertTrue($reply->fresh()->isBest);

        // send delete request to delete reply endpoint

        $this->delete("/replies/{$reply->id}");

        // check if best_reply_id in threads table was updated to null after delete best reply

        $this->assertNull($thread->fresh()->best_reply_id);
    }
}
