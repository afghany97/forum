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

        $this->assertEquals($this->thread->id, $reply->Thread->id);
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

    public function test_if_login_user_and_confirmed_can_submit_add_reply_form()
    {
        // create user and sign in and confirm

        $this->signIn($user = create('App\User'))->confirm($user);

        // create thread

        $thread = create('App\Thread');

        // create reply

        $reply = create('App\Reply');

        // send post request with reply data to store it at database

        $this->post($thread->path() . "/replies", $reply->toArray());

        // send get request for render thread to test if the reply added successfully

        $this->get($thread->path())
            ->assertStatus(200)
            ->assertSee($reply->body);
    }

    /**@test */

    public function test_guest_can_not_delete_reply()
    {
        // this test expect AuthenticationException

        $this->expectException('Illuminate\Auth\AuthenticationException');

        // create reply

        $reply = create('App\Reply');

        // send delete request to delete reply end point

        $this->delete("/replies/{$reply->id}")
            ->assertRedirect("/login");
    }

    /**@test */

    public function test_unauthorised_user_can_not_delete_reply()
    {
        // this test expect AuthorizationException

        $this->expectException('Illuminate\Auth\Access\AuthorizationException');

        // create reply

        $reply = create('App\Reply');

        // create user and sign in

        $this->signIn()
            // send delete request to delete reply end point

            ->delete("/replies/{$reply->id}")
            // expect response status 403

            ->assertStatus(403);
    }

    /**@test */

    public function test_authorised_user_can_delete_reply()
    {
        // create user and sign in

        $this->signIn();

        // create reply belongs to authenticated user

        $reply = create("App\Reply", ['user_id' => auth()->id()]);

        // send delete request to delete reply end point

        $this->delete("/replies/{$reply->id}")
            // expect response status 302

            ->assertStatus(302);
    }

    /**@test */

    public function test_unauthorised_user_can_not_update_reply()
    {
        // this test expect AuthorizationException

        $this->expectException("Illuminate\Auth\Access\AuthorizationException");

        // create user and sign in

        $this->signIn();

        // create reply

        $reply = create("App\Reply");

        $replyBody = "dummy data";

        // send put request to update reply end point with reply body data

        $this->put("/replies/{$reply->id}", ['body' => $replyBody])
            // expect response status 403

            ->assertStatus(403);
    }

    /**@test */

    public function test_guest_can_not_update_reply()
    {
        // this test expect AuthenticationException

        $this->expectException('Illuminate\Auth\AuthenticationException');

        // create reply

        $reply = create('App\Reply');

        $replyBody = "dummy data";

        // send put request to update reply end point with reply body data

        $this->put("/replies/{$reply->id}", ['body' => $replyBody])
            // expect redirect to login page

            ->assertRedirect("/login");
    }

    /**@test */

    public function test_authorised_user_can_update_reply()
    {
        // create user and sign in

        $this->signIn();

        // create reply belogn to authenticated user

        $reply = create("App\Reply", ['user_id' => auth()->id()]);

        $replyBody = "dummy data";

        // send put request to update reply end point with reply body data

        $this->put("/replies/{$reply->id}", ['body' => $replyBody])
            // expcet response status code 302

            ->assertStatus(302)
            // expcet redirect to reply path

            ->assertRedirect($reply->path());
    }

    /**@test */

    public function test_authorised_user_can_see_update_reply_form()
    {
        // create user and sign in

        $this->signIn();

        // create reply belogn to authenticated user

        $reply = create("App\Reply", ['user_id' => auth()->id()]);

        // send patch request to update reply form end point

        $this->patch("/replies/{$reply->id}")
            // expcet response status code 200

            ->assertStatus(200)
            // expect see reply body

            ->assertSee($reply->body);
    }

    /**@test */

    public function test_unauthorised_user_can_not_see_update_reply_form()
    {
        // this test expect AuthorizationException

        $this->expectException("Illuminate\Auth\Access\AuthorizationException");

        // create user and sign in

        $this->signIn();

        // create reply

        $reply = create("App\Reply");

        // send patch request to update reply form end point

        $this->patch("/replies/{$reply->id}")
            // expect response status 403

            ->assertStatus(403)
            // expect dont see reply body

            ->assertDontSee($reply->body);
    }

    /**@test */

    public function test_guest_can_not_see_update_reply_form()
    {
        // this test expect AuthenticationException

        $this->expectException('Illuminate\Auth\AuthenticationException');

        // create reply

        $reply = create("App\Reply");

        // send patch request to reply update end point

        $this->patch("/replies/{$reply->id}")
            // expect redirect to login page

            ->assertRedirect('/login');
    }

    /**@test */

    public function test_user_may_not_add_more_than_one_reply_per_minute()
    {
        // create user and sign in

        $this->signIn($user = create('App\User'))->confirm($user);

        // create thread

        $thread = create('App\Thread');

        // create reply

        $reply = create("App\Reply");

        // send post request to create reply end point

        $this->post($thread->path() . "/replies", $reply->toArray())

            // expect response status 302

            ->assertStatus(302);

        // send post request to create reply end point

        $this->post($thread->path() . "/replies", $reply->toArray())

            // expect response status 429

            ->assertSee("you are replies too much , take a break :)")

            ->assertStatus(429);
    }

    /**@test */

    public function test_notify_all_mentioned_users_in_reply_body()
    {
        // create user

        $muhammad = create('App\User', ['name' => 'muhammad']);

        // create user

        $ahmed = create('App\User', ['name' => 'ahmed']);

        // sign in user with name "muhammad"

        $this->signIn($muhammad)->confirm($muhammad);

        $thread = create('App\Thread');

        // make instance of reply with override body

        $reply = make('App\Reply', ['body' => 'test mention @ahmed']);

        // send post request to create reply end point

        $this->post($thread->path() . "/replies", $reply->toArray());

        // expcet user with name "ahmed" recive notification

        $this->assertCount(1, $ahmed->notifications);

    }

    /**@test */

    public function test_fetch_all_mention_users_in_reply_body()
    {
        // create user and sign in

        $this->signIn();

        // create rely with override body

        $reply = create('App\Reply', ['body' => '@firstuser want talk to @seconduser']);

        // send post request to create reply end point

        $this->post($this->thread->path() . "/replies", $reply->toArray());

        // expect result of mentionedUsers method to be like first param

        $this->assertEquals(['firstuser', 'seconduser'], $reply->mentionedUsers());
    }

    /**@test */

    public function test_mention_user_have_tag_in_reply_body()
    {
        // create user and sign in

        $this->signIn();

        // create reply with override the body

        $reply = create('App\Reply', ['body' => 'hello @foobar']);

        // expect the body of reply to be like first param

        $this->assertEquals('hello <a href="/profiles/foobar">@foobar</a>', $reply->body);
    }
}
