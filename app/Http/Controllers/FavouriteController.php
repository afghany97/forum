<?php

namespace App\Http\Controllers;

use App\Favourite;

use App\Reply;

use App\Thread;

use Illuminate\Http\Request;

class FavouriteController extends Controller
{     

    public function __construct()
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
    public function store(Thread $thread = null ,Reply $reply = null)
    {
        // check if the request want to favouirte reply

        if(Favourite::gotFirstWord(request()->path()) == 'replies'){

            // favourite reply end point "replies/{Reply->id}/favourite"

            $reply->favourite();

            // repear the flash message

            session()->flash('message' , 'The favourite reply added successfully');
        }
        else{

            // favourite thread end point "threads/{thread->id}/favourite"

            $thread->favourite();

            // repear the flash message

            session()->flash('message' , 'The favourite thread added successfully');
        }
        return back();
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Favourite  $favourite
     * @return \Illuminate\Http\Response
     */
    public function show(Favourite $favourite)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Favourite  $favourite
     * @return \Illuminate\Http\Response
     */
    public function edit(Favourite $favourite)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Favourite  $favourite
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Favourite $favourite)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Favourite  $favourite
     * @return \Illuminate\Http\Response
     */
    public function destroy(Thread $thread = null ,Reply $reply = null)
    {
        // check if the request want to favouirte reply

        if(Favourite::gotFirstWord(request()->path()) == 'replies'){

            // unfavourite reply end point "replies/{Reply->id}/favourite"

            $reply->unfavourite();

            // repear the flash message

            session()->flash('message' , 'The reply unfavourite successfully');
        }
        else{

            // unfavourite thread end point "threads/{thread->id}/favourite"

            $thread->unfavourite();

            // repear the flash message

            session()->flash('message' , 'The thread unfavourite successfully');
        }
        return back();
    }
}
