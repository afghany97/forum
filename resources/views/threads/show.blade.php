@extends('layouts.app')

@section('content')
    <div class="container">

        <div class="row">
        
            <div class="col-md-8 ">
        
                <div class="panel panel-default">
        
                    <div class="panel-heading">

                        <a href="{{route('profile' , $thread->User)}}">

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
                 @foreach($replies as $Reply)

                     @include('threads.reply')
        
                @endforeach

                {{$replies->links()}}
            
                @if(auth()->check())

                    @include('threads.replyForm')

                @else

                <p class="text-center">

                    <a href="{{route('login')}}">

                        Sign in
                
                    </a>
                    
                     to be albe to reply to thread
                    
                </p>   

                @endif

            </div>

            <div class="col-md-4">
                
                <p>

                    This thread was published from {{$thread->created_at->diffForHumans()}}

                    by <a href="#"> {{$thread->User->name}} </a> and currently has {{$thread->replies_count}} 

                    {{str_plural('comment',$thread->replies_count)}}

                </p>

            </div>

        </div>
        
    </div>

</div>  
    
@endsection
