@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <div class="panel panel-default">
                <div class="panel-heading">{{$thread->title}}</div>

                <div class="panel-body">
                        
                        <div class="body">
                            {{$thread->body}}
                        </div>
                        
                </div>
            </div>
        </div>
    </div>
    
    @foreach($thread->Replies as $Reply)
    
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <div class="panel panel-default">
                <div class="panel-heading">
                
                    <a href="#"> 
                        {{$Reply->User->name}}
                    </a>
                    From {{$Reply->created_at->diffForHumans()}}
                        
                </div>

                <div class="panel-body">
                        {{$Reply->body}}
                </div>
            </div>
        </div>
    </div>
    
    @endforeach

</div>
@endsection
