<?php

namespace App\Http\Controllers;

use App\Events\ThreadDeleted;
use App\Events\ThreadHasUpdated;
use App\Thread;

use App\Channel;

use App\ThreadsVistores;

use App\filters\ThreadsFilters;


use App\Http\Requests\ThreadsRequestForm;


class ThreadsController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth')->except(['index', 'show']);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    public function index(Channel $channel, ThreadsFilters $filters)
    {
        // fetch all threads in descending order with filter them for asking filters

        $threads = Thread::latest()->filter($filters);

        // check if channel object exists

        if ($channel->exists) {

            // fetch all threads for channel in descending order

            $threads->where('channel_id', $channel->id);
        }

        // check if request ask for json responce

        if (request()->wantsJson())

            // return the collection of threads

            return $threads;

        $threads = $threads->paginate(10);

        $trendingThreads = Thread::fetchTopTrendingThreads();

        $archives = Thread::archives();

        // return view with threads

        return view('threads.index', compact('threads', 'trendingThreads' ,'archives'));
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
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(ThreadsRequestForm $form)
    {
        // create new thread 

        $thread = Thread::addThread(request()->all());

        // repear flash message

        session()->flash('message', 'The thread created successfully');

        // redirect to thread path

        return redirect($thread->path());
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Thread $thread
     * @return \Illuminate\Http\Response
     */
    public function show($channel, Thread $thread)
    {
        // mark thread as read

        $thread->read();

        // fetch the replies belongs to this thread with pagination

        $replies = $thread->replies()->paginate(5);

        // fetch first reply

        $bestReply = (new \App\Reply)->find($thread->best_reply_id);

        // return view with specific thread and replies

        return view('threads.show', compact(['thread', 'replies', 'bestReply']));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Thread $thread
     * @return \Illuminate\Http\Response
     */
    public function edit(Channel $channel, Thread $thread)
    {
        return view('threads.edit', compact('channel', 'thread'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  \App\Thread $thread
     * @return \Illuminate\Http\Response
     */
    public function update(Channel $channel, Thread $thread)
    {
        // validate the request data

        $this->validate(request(), [

            'title' => 'required|spamDetect',

            'body' => 'required|spamDetect'
        ]);

        // update thread

        $thread->update([

            'title' => request('title'),

            'body' => request('body'),

            'slug' => request('title')
        ]);

        // fetch thread from trending table if exists

        if ($trendThread = ThreadsVistores::where('thread_id', $thread->id)->first())

            // update the thread title in trending table

            $trendThread->update(['thread_title' => request('title')]);

        event(new ThreadHasUpdated($thread));

        // repear flash message

        session()->flash('message', 'The thread updated successfully');

        // redirect to thread page

        return redirect($thread->path());
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Thread $thread
     * @return \Illuminate\Http\Response
     */
    public function destroy($channel, Thread $thread)
    {
        // check if user can delete this thread

        $this->authorize('delete', $thread);

        // delete thread

        if($thread->delete())

            event(new ThreadDeleted($thread));

        // repear flash message

        session()->flash('message', 'The thread deleted successfully');

        // redirect to threads page

        return redirect(route('threads'));
    }
}
