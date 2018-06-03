<?php

namespace App\Http\Controllers;

use App\Thread;
use App\User;

class AdminsController extends Controller
{
    public function __construct()
    {
        $this->middleware('admin');
    }

    public function index()
    {
        return view('admin.index');
    }

    public function showUsers()
    {
        return view('admin.users', ['users' => User::latest()->paginate(10)]);
    }

    public function showThreads()
    {
        return view('admin.threads', ['threads' => Thread::latest()->paginate(10)]);
    }
}
