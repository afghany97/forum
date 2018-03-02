<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Thread;

use App\Reply;

use App\spam\spam;

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
    public function store($channel , Thread $thread , spam $spam)
    {
         // validate the request data 

        $this->validate(request(),[

            'body' => 'required'

        ]);

        try {
        
            $spam->detect(request('body'));
            
        } catch (\Exception $e) {
            
            return view('errors.spam', compact('e'));
        }

        // call addReply method and send the param's

        $thread->addReply([

            'body' => request('body'),
        
            'user_id' => auth()->id()
        ]);

        // return the previous page

        session()->flash('message' , 'The reply created successfully');
        
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
        $this->authorize('update' , $reply);
        
        return view('replies.update' , compact('reply'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Reply $reply , spam $spam)
    {
        $this->authorize('update' , $reply);

        $this->validate(request(),[

            'body' => 'required'

        ]);

        $spam->detect(request('body'));

        $reply->update(request(['body']));

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
        $this->authorize('delete' , $reply);
        
        $reply->delete();

        return back();
    }
}
