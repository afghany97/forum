@extends('layouts.app')

@section('content')
    <div class="container">

        <div class="row">
        
            <div class="col-md-8 ">
        
                <div class="panel panel-default">
        
                    <div class="panel-heading level">

                        <a href="{{route('profile' , $thread->User)}}">

                            {{$thread->User->name}}
                         
                        </a>
        
                         Posted ...
                        
                        {{$thread->title}}
                    

                        <div class="text-right flex" style="float:right;">

                            <form method="POST" action="/threads/{{$thread->id}}/favourite">

                                {{csrf_field()}}

                                <button type="submit" class="btn btn-primary btn-xs" {{$thread->IsFavourited() ? 'disabled' : ''}}>

                                    {{$thread->favourites->count()}} {{str_plural('Favourite' , $thread->favourites->count())}}

                                </button>                        

                            </form>

                        </div>

                    </div>
                        
                    <div class="panel-body">
                            
                            <div class="body">
        
                                {{$thread->body}}
        
                            </div>
        
                    </div>

                    @can('delete',$thread)

                        <div class="panel-footer">
                        
                            <form method="POST" action="{{$thread->path()}}">
                                
                                {{csrf_field()}}

                                {{method_field('DELETE')}}

                                <button type="submit" class="btn btn-danger btn-xs">Delete Thread</button>

                            </form>

                        </div>
                    
                    @endcan

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

                    by <a href="{{route('profile' , $thread->User)}}"> {{$thread->User->name}} </a> and currently has {{$thread->replies_count}} 

                    {{str_plural('comment',$thread->replies_count)}}

                </p>

            </div>

        </div>
        
    </div>

</div>  
    
@endsection
