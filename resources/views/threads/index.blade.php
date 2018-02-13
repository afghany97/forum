@extends('layouts.app'  )

@section('content')
    <div class="container">
    
        <div class="row">
    
            <div class="col-md-8 col-md-offset-2">

                 @forelse($threads as $thread)
    
                    <div class="panel panel-default">
        
                        <div class="panel-heading">

                          <a href="{{$thread->path()}}">
                                   
                                <h4>{{$thread->title}}</h4>

                            </a>

                        </div>

                        <div class="panel-body">
                                
                            <div class="body">
                            
                                {{$thread->body}}
                            
                            </div>
                            
                            <hr>

                            <strong>{{$thread->replies_count}} {{str_plural('reply', $thread->replies_count)}}</strong>
                            
                        </div>
             
                    </div>

                @empty

                    <h1>There is no threads</h1>

               @endforelse
            
            </div>
        
        </div>

    </div>

@endsection
