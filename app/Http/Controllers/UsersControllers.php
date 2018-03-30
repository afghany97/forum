<?php

namespace App\Http\Controllers;

use App\Exceptions\CantConfirmEmailWithOutLogin;
use App\Exceptions\CantConfirmOtherUserEmail;
use App\Exceptions\inValidConfirmationToken;
use App\User;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class UsersControllers extends Controller
{
    /**
     * @param $token
     * @return \Illuminate\Http\RedirectResponse
     * @throws inValidConfirmationToken
     */

    public function index($token)
    {
        try{

            // fetch user by his token

            $user = User::where('confirmation_token' , $token)

                ->firstOrFail();
        }
        catch (ModelNotFoundException $e)
        {
            // throw exception if user not found

            Throw new inValidConfirmationToken();
        }

        // check if user not sign in

        if(!auth()->check())

            // throw exception

            throw new CantConfirmEmailWithOutLogin();

        // check if authenticated user not the owner of the confirmation token

        if(auth()->id() != $user->id)

            // throw exception

            throw new CantConfirmOtherUserEmail();


        // check if user email not confirmed

        if(! $user->confirmed)
        {
            // confirm user email

            $user->update(['confirmed' => true]);

            // return to threads page with flash message 'your account confirmed'

            return redirect('/threads')->with('message' , 'your account confirmed');
        }

        // return to threads page with flash message "your account already confirmed , thanks"

        return redirect('/threads')->with('message' , "your account already confirmed , thanks");
    }
}
