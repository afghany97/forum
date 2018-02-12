<?php

namespace App\Http\Controllers;

use App\Thread;

use App\Channel;

use App\User;

use App\filters\ThreadsFilters;

use Illuminate\Http\Request;

class ThreadsController extends Controller
{

    public function __construct ()
    {
        $this->middleware('auth')->only(['create' , 'store']);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    
    public function index(Channel $channel , ThreadsFilters $filters)
    {
        // fetch all threads in descending order with filter them for asking filters

        $threads = Thread::latest()->filter($filters);

        // check if channel object exists

        if($channel->exists){

            // fetch all threads for channel in descending order

            $threads->where('channel_id' , $channel->id);
        }

        // check if request ask for json responce

        if(request()->wantsJson())

            // return the collection of threads

            return $threads;

        $threads = $threads->get();

        // return view with threads

        return view('threads.index', compact('threads'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        // return create thread form

        return view('threads.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {

        // validate the request data 

        $this->validate(request(),[
            
            'title' => 'required',

            'body' => 'required',

            'channel_id' => 'required|exists:channels,id'
        ]);


        $thread = Thread::addThread(request()->all());

        return redirect($thread->path());
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Thread  $thread
     * @return \Illuminate\Http\Response
     */
    public function show($channel , Thread $thread)
    {

        // return view with specific thread
        $replies = $thread->replies()->paginate(5);

        return view('threads.show',compact(['thread' , 'replies']));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Thread  $thread
     * @return \Illuminate\Http\Response
     */
    public function edit(Thread $thread)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Thread  $thread
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Thread $thread)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Thread  $thread
     * @return \Illuminate\Http\Response
     */
    public function destroy(Thread $thread)
    {
        //
    }
}
