@extends('layouts.app')

@section('content')

    <div class="row">

        <div class="col-md-8">

            <div class="panel panel-default">

                <div class="panel-heading level">

                    <a href="{{route('profile' , $thread->User)}}" class="mr-1">

                        <img src="{{$thread->User->avatarPath()}}" alt="{{$thread->User->name}}"
                                class="smallAvatar mr-5">

                        {{$thread->User->name }}

                    </a>

                    published ...

                    {{$thread->title}}

                    @if(auth()->check())

                        @if(auth()->user()->is_supervisor || auth()->user()->is_admin)

                            <div class="text-right flex mr-10">

                                <form method="POST" action="{{route('thread.lockToggle',$thread)}}">

                                    {{csrf_field()}}

                                    {{method_field('PUT')}}

                                    <button class="{{$thread->is_locked ? "btn btn-default btn-xs" : "btn btn-danger btn-xs"}}" 
                                        
                                        title="{{$thread->is_locked ? "thread un-lock" : "thread lock"}}">

                                        {!! $thread->is_locked ? '<i class="fas fa-lock-open"></i>' : '<i class="fas fa-lock"></i>' !!}

                                    </button>

                                </form>
                        
                            </div>
                            
                        @endif

                        <div class="text-right flex mr-10" style="display:contents">
                        
                            @if($thread->IsFavourited())

                                <form method="POST" action="{{route('thread.unfavourite',$thread)}}">

                                    {{csrf_field()}}

                                    {{method_field('DELETE')}}

                                    <button  class="btn btn-primary btn-xs">

                                        {{$thread->favourites->count()}}

                                        <i class="far fa-heart"></i>

                                    </button>

                                </form>
                        
                            @else
                        
                                <form method="POST" action="{{route('thread.favourite',$thread)}}">

                                    {{csrf_field()}}

                                    <button  class="btn btn-default btn-xs">

                                        {{$thread->favourites->count()}}

                                        <i class="fas fa-heart"></i>

                                    </button>

                                </form>

                            @endif

                        </div>

                    @endif

                </div>

                <div class="panel-body">

                    <div class="body">

                        {{$thread->body}}

                    </div>

                </div>

                @if(auth()->check())

                    <div class="panel-footer level">

                        @can('delete',$thread)

                            <form method="POST" action="{{route('thread.destroy',[$thread->channel,$thread])}}"
                                    class="mr-5">

                                {{csrf_field()}}

                                {{method_field('DELETE')}}

                                <button class="btn btn-danger btn-xs">Delete Thread</button>

                            </form>

                            <form method="POST" action="{{route('thread.edit',[$thread->channel,$thread])}}">

                                {{csrf_field()}}

                                {{method_field('patch')}}

                                <button class="btn btn-default btn-xs">Edit Thread</button>

                            </form>

                        @endcan

                        <a href="{{route('thread.history',$thread)}}" class="btn btn-default btn-xs ml-a">Edit History</a>  

                    </div>

                @endif

            </div>

            @if($bestReply)

                @component('replies._reply',['reply' => $bestReply,'thread' => $thread])
                    
                @endcomponent

            @endif

            @foreach($replies as $reply)

                @component('replies._reply',compact('reply','thread'))
                    
                @endcomponent

            @endforeach

            {{$replies->links()}}

            @include('replies._create')

            @include('layouts.errors')

        </div>

        @if(auth()->check())

            <div class="col-md-4">

                @include('threads._rightSide')

            </div>

        @endif

    </div>

@endsection