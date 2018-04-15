<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\User;

use App\Activity;

class ProfilesController extends Controller
{

    public function __construct ()
    {
        $this->middleware('auth');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(User $user)
    {
        $profileUser = $user;

        // fetch the activities for given user 

        $activites = Activity::feeds($user);
        
        // return view with activites and user object

        return view('profiles.show', compact(['profileUser','activites']));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param $user
     * @return \Illuminate\Http\Response
     */
    public function edit(User $user)
    {
        return view('profiles.edit' , compact('user'));

    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(User $user)
    {
        $this->validate(request(),[
           'name'=> 'required|spamDetect'
        ]);

        $this->authorize('create' , $user);

        $user->update(['name' => request('name')]);

        return redirect(route('profile',$user))->with('message',"updated successfully");

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
