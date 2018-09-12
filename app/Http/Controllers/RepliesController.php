<?php

namespace App\Http\Controllers;


use App\Http\Requests\ReplyRequestForm;

use App\Thread;

use App\Reply;

class RepliesController extends Controller
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
    public function store($channel , Thread $thread , ReplyRequestForm $form)
    {
        // call addReply method and send the param's

        $thread->addReply([

            'body' => request('body'),
        
            'user_id' => auth()->id()
        ]);

        // repear flash message

        session()->flash('message' , 'The reply created successfully');
        
        // return the previous page
        
        return back();
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Reply $reply)
    {   
        // check if user can edit this reply

        $this->authorize('update' , $reply);
        
        // return view with reply object

        return view('replies.edit' , compact('reply'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Reply $reply)
    {
        // check if user can edit this reply
        
        $this->authorize('update' , $reply);

        // validate the request data

        $this->validate(request(),[

            'body' => 'required|spamDetect'

        ]);
        
        // update the reply data upon given request data

        $reply->update(request(['body']));

        // redirect to reply path

        return redirect($reply->path());
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Reply $reply)
    {
        // check if user can delete this reply
        
        $this->authorize('delete' , $reply);
        
        // delete the reply

        $reply->delete();

        // redirect to preivous page
        
        return back();
    }

    public function bestReply(Reply $reply)
    {
        $this->authorize('update',$reply->thread);

        $reply->thread->markReplyAsBest($reply);

        return redirect($reply->path());
    }
}
