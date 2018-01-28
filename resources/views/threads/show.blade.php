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
        
            @include('threads.reply')
        
        @endforeach

    </div>

@endsection
