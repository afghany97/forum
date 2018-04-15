<?php

namespace App\Http\Controllers;

use App\User;

class SupervisorController extends Controller
{

    /**
     * SupervisorController constructor.
     */
    public function __construct()
    {
        $this->middleware('admin');
    }

    public function store(User $user)
    {
        $user->supervisorToggle();

        return back();
    }
}
