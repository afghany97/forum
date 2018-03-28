<?php

namespace App\Http\Controllers;

use App\Thread;

use App\Channel;

use App\ThreadsVistores;

use App\User;

use App\filters\ThreadsFilters;

use Illuminate\Http\Request;

use App\Http\Requests\ThreadsRequestForm;

use Carbon\Carbon;

class ThreadsController extends Controller
{

    public function __construct ()
    {
        $this->middleware('auth')->except(['index' , 'show']);
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

        $threads = $threads->paginate(10);

        $trending = ThreadsVistores::fetchTopTrendingThreads();

        // return view with threads

        return view('threads.index', compact('threads' , 'trending'));
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
    public function store(ThreadsRequestForm $form)
    {
        // create new thread 

        $thread = Thread::addThread(request()->all());

        // repear flash message

        session()->flash('message' , 'The thread created successfully');

        // redirect to thread path

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
        // mark thread as read

        $thread->read();

        // fetch the replies belongs to this thread with pagination

        $replies = $thread->replies()->paginate(5);

        // return view with specific thread and replies

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
    public function destroy($channel , Thread $thread)
    {
        // check if user can delete this thread

        $this->authorize('delete' , $thread);
        
        // delete thread

        $thread->delete();

        // repear flash message

        session()->flash('message' , 'The thread deleted successfully');

        // redirect to threads page
        
        return redirect(route('threads'));
    }

    function  test (){

        return request()->ip();
    }
}
