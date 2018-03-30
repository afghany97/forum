<?php

namespace Tests\Feature;

use App\Mail\ConfirmYourEmail;
use Illuminate\Auth\Events\Registered;
use Illuminate\Support\Facades\Mail;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class RegisterationTest extends TestCase
{
    use DatabaseTransactions;

    /** @test */

    public function sending_confiramtion_mail_for_new_users()
    {
        // use fake mail

        Mail::fake();

        // register new user

        event(new Registered(create('App\User')));

        // check if the mail send to new user

        Mail::assertSent(ConfirmYourEmail::class);

    }

    /** @test */

    public function test_if_user_have_confirmation_token($user = null)
    {
        // create user

        $user = $user ?: create('App\User');

        // check if his confirmation token exists

        $this->assertNotNull($user->confirmation_token);

    }

    /** @test */

    public function test_if_user_can_confirm_his_email()
    {
        // create user

        $user = create('App\User');

        // sign in the user

        $this->signIn($user);

        // check if user unconfirmed his email

        $this->assertSame(false,$user->confirmed);

        // check if user have confirmation token

        $this->test_if_user_have_confirmation_token($user);

        // send get request to confirm his email

        $this->get("/register/confirm/".$user->confirmation_token)

            // check if session have message message for user

            ->assertSessionHas('message','your account confirmed');

        // check if user email confirmed

        $this->assertSame(true,$user->fresh()->confirmed);

    }

    /** @test */

    public function handle_if_user_try_to_confirm_his_account_again()
    {
        // create user

        $user = create('App\User');

        // sigin in the user

        $this->signIn($user);

        // check if user unconfirmed his email

        $this->assertSame(false,$user->confirmed);

        // send get request to confirm his email

        $this->get("/register/confirm/".$user->confirmation_token)

            // check if session have message message for user

            ->assertSessionHas('message','your account confirmed');

        // check if user email confirmed

        $this->assertSame(true,$user->fresh()->confirmed);

        // send get request to confirm his email again

        $this->get("/register/confirm/".$user->confirmation_token)

            // check if session have message message for user

            ->assertSessionHas('message',"your account already confirmed , thanks");

        // check if user email confirmed "didn't change"

        $this->assertSame(true,$user->fresh()->confirmed);
    }

    /** @test */

    public function test_if_user_send_invalid_token_to_confirm()
    {
        // create user

        $user = create('App\User');

        // check if user unconfirmed his email

        $this->assertSame(false,$user->confirmed);

        // send get request to confirm his email with invalid token

        $this->get("/register/confirm/invalidtoken")

            // check if this message "invalid token.." appear in page

            ->assertSee("invalid token..")

            // check if status code of response 406

            ->assertStatus(406);

        // check if user still unconfirmed his email

        $this->assertSame(false,$user->fresh()->confirmed);
    }

    /** @test */

    public function user_can_not_confirm_his_email_without_login()
    {
        // create user

        $user = create('App\User');

        // test if user have confirmation token

        $this->test_if_user_have_confirmation_token($user);

        // test if user not confirm his email

        $this->assertFalse($user->confirmed);

        // check if user not signin

        $this->assertFalse(auth()->check());

        // send get request to confirm user email

        $this->get("/register/confirm/".$user->confirmation_token)

            // check if user see this message in page

            ->assertSee("you should login first befor try to confirm your email.")

            // check if status code 401

            ->assertStatus(401);

        // login the user

        $this->signIn($user);

        // check if user sigin

        $this->assertTrue(auth()->check());

        // send get request to confirm user email

        $this->get("/register/confirm/".$user->confirmation_token)

            // check if status code 302

            ->assertStatus(302)

            // check if redirect to threads page

            ->assertRedirect('/threads')

            // check if user got feedback

            ->assertSessionHas('message' , 'your account confirmed');

        // check if user confirmed

        $this->assertTrue($user->fresh()->confirmed);
    }

    /** @test */

    public function test_if_user_can_not_confirm_other_user_email()
    {
        // create user1

        $user1 = create('App\User');

        // create user2

        $user2 = create('App\User');

        // test if user have confirmation token

        $this->test_if_user_have_confirmation_token($user1);

        $this->test_if_user_have_confirmation_token($user2);

        // test if user not confirm his email

        $this->assertFalse($user1->confirmed);

        $this->assertFalse($user2->confirmed);

        // sign in user1

        $this->signIn($user1);

        // check if user1 singedin

        $this->assertTrue(auth()->check());

        $this->assertTrue(auth()->id() == $user1->id);

        // send get request from user1 to confirm user2 email

        $this->get("/register/confirm/".$user2->confirmation_token)

            // check if user see this message in page

            ->assertSee("you can't confirm other user email.")

            // check if status code 401

            ->assertStatus(401);

    }
}
