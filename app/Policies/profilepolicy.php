<?php

namespace App\Policies;

use App\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class profilepolicy
{
    use HandlesAuthorization;

    /**
     * @param User $user
     * @param User $ownerUser
     * @return bool
     */
    public function create(User $user , User $ownerUser)
   {
       return $user->id === $ownerUser->id;
   }
}
