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

    public function test_if_user_have_confirmation_token()
    {
        // create user

        $user = create('App\User');

        // check if his confirmation token exists

        $this->assertNotNull($user->confirmation_token);

    }

    /** @test */

    public function test_if_user_can_confirm_his_email()
    {
        // create user

        $user = create('App\User');

        // check if user unconfirmed his email

        $this->assertSame(false,$user->confirmed);

        // check if user have confirmation token

        $this->test_if_user_have_confirmation_token();

        // send get request to confirm his email

        $this->get("/register/confirm/".$user->confirmation_token)

            // check if session have flash message for user

            ->assertSessionHas('flash','your account confirmed');

        // check if user email confirmed

        $this->assertSame(true,$user->fresh()->confirmed);

    }

    /** @test */

    public function handle_if_user_try_to_confirm_his_account_again()
    {
        // create user

        $user = create('App\User');

        // check if user unconfirmed his email

        $this->assertSame(false,$user->confirmed);

        // send get request to confirm his email

        $this->get("/register/confirm/".$user->confirmation_token)

            // check if session have flash message for user

            ->assertSessionHas('flash','your account confirmed');

        // check if user email confirmed

        $this->assertSame(true,$user->fresh()->confirmed);

        // send get request to confirm his email again

        $this->get("/register/confirm/".$user->confirmation_token)

            // check if session have flash message for user

            ->assertSessionHas('flash',"your account already confirmed , thanks");

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

        $this->get("/register/confirm/invali    dtoken")

            // check if this message "invalid token.." appear in page

            ->assertSee("invalid token..")

            // check if status code of response 406

            ->assertStatus(406);

        // check if user still unconfirmed his email

        $this->assertSame(false,$user->fresh()->confirmed);
    }
}
