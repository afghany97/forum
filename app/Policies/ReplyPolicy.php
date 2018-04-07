<?php

namespace App\Policies;

use App\User;

use App\Reply;

use Illuminate\Auth\Access\HandlesAuthorization;

class ReplyPolicy
{
    use HandlesAuthorization;

    /**
     * Create a new policy instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    public function delete(User $user , Reply $reply)
    {
        // check if authenticated user the owner of reply "can delete it"

        return $user->id == $reply->user_id;
    }

    public function update(User $user , Reply $reply)
    {
        // check if authenticated user the owner of reply "can update it"
        
        return $user->id == $reply->user_id;
    }

    public function create(User $user)
    {
        // fetch last reply for authenticated user

        $lastReply = $user->fresh()->lastReply;
        
        // check if the user didn't reply befor

        if(! $lastReply) return true;

        // return bool value if the last reply for user was published befor 1 min ago 

        return ! $lastReply->justPublished() && $user->confirmed;
    }
}
