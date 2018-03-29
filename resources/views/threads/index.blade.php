@extends('layouts.app'  )

@section('content')
    <div class="container">
    
        <div class="row">
    
            <div class="col-md-8">

                 @forelse($threads as $thread)
    
                    <div class="panel panel-default">
        
                        <div class="panel-heading">

                          <a href="{{$thread->path()}}">

                            @if($thread->hasUpdatedFor())
                                   
                                <strong>{{$thread->title}}</strong>

                            @else

                                {{$thread->title}}

                            @endif

                                <hr>

                          </a>

                            by :

                            <img src="/storage/{{$thread->user->avatar_path}}" alt="{{$thread->user->name}}" class="smallAvatar mr-5">

                            <a href="{{route('profile',$thread->user)}}">

                                {{$thread->user->name}}

                            </a>

                        </div>

                        <div class="panel-body">
                                
                            <div class="body">
                            
                                {{$thread->body}}
                            
                            </div>
                            
                            <hr>

                            <strong>{{$thread->replies_count}} {{str_plural('reply', $thread->replies_count)}}</strong>
                            
                        </div>

                        <div class="panel-footer">

                             {{count(App\ThreadsVistores::ThreadVists($thread))}} vists

                        </div>
             
                    </div>

                @empty

                    <h1>There is no threads</h1>

               @endforelse
             
                {{$threads->links()}}
            
            </div>

            <div class="col-md-4">

                <div class="panel panel-default">

                    <div class="panel panel-heading">

                        <strong>Trending</strong>

                    </div>

                    <div class="panel-body">

                        <ul class="list-group">

                            @forelse($trending as $thread)

                                <li class="list-group-item">

                                    @php

                                        $trendThread = App\Thread::find($thread->id);

                                    @endphp

                                    <a href="{{$trendThread->path()}}">

                                        {{$trendThread->title}}

                                    </a>

                                    visted : {{$thread->trend}} times

                                </li>

                            @empty

                                <strong>There is no trending threads right now</strong>

                            @endforelse

                        </ul>

                    </div>

                </div>

            </div>

    </div>

@endsection
