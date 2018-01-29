@extends('layouts.app')

@section('content')
    <div class="container">

        <div class="row">
        
            <div class="col-md-8 col-md-offset-2">
        
                <div class="panel panel-default">
        
                    <div class="panel-heading">

                        <a href="#">

                            {{$thread->User->name}}
                         
                        </a>
        
                         Posted ...
        
                        {{$thread->title}}
                    
                    </div>
                        
                    <div class="panel-body">
                            
                            <div class="body">
        
                                {{$thread->body}}
        
                            </div>
        
                    </div>

                </div>

            </div>

        </div>
        
        @foreach($thread->Replies as $Reply)

            {{dd($Reply->User)}} <!--  here is the error $Reply->User return null !!!!!! -->
        
            @include('threads.reply')
        
        @endforeach

    </div>
    
    @if(auth()->check())

        <div class="row">
        
            <div class="col-md-8 col-md-offset-2">
     
                <form action="{{$thread->path() . '/replies'}}" method="POST">
                    
                    <textarea class="form-control" placeholder="leave a reply..." id="body" name="body" rows="4"></textarea>

                    <button type="submit" class="btn btn-defualt">Submit</button>

                </form>

            </div>
        
        </div>
    @else
        <p class="text-center">
            <a href="{{route('login')}}">

                Sign in
        
            </a>
        
             to be albe to reply to thread
        
        </p>        
    
    @endif

@endsection
