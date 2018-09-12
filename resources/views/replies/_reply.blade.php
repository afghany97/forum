<div class="{{$reply->isBest() ? "panel panel-success" : "panel panel-default"}}">

        <div class="panel-heading level" id="reply-{{$reply->id}}">

            <div>

                <a href="{{route('profile' , $thread->User)}}">

                    {{$reply->User->name}}

                </a>

                From {{$reply->created_at->diffForHumans()}}

            </div>

            @if(auth()->check())

                <div class="flex text-right">

                    @if($reply->IsFavourited())

                        <form method="POST" action="{{route('reply.unfavourite',$reply)}}">

                            {{csrf_field()}}

                            {{method_field("DELETE")}}

                            <button class="btn btn-primary btn-xs">

                                {{$reply->favourites->count()}}

                                <i class="far fa-heart"></i>

                            </button>

                        </form>

                    @else

                        <form method="POST" action="{{route('reply.favourite',$reply)}}">

                            {{csrf_field()}}

                            <button class="btn btn-default btn-xs">

                                {{$reply->favourites->count()}}

                                <i class="fas fa-heart"></i>

                            </button>

                        </form>

                    @endif

                </div>

            @endif

        </div>

        <div class="panel-body">

            {!! $reply->body !!}

        </div>

        <div class="panel-footer level">

            @can('delete' , $reply)

                <form method="POST" action="{{route('reply.destroy',$reply)}}" class="mr-1 fl">

                    {{csrf_field()}}

                    {{method_field('DELETE')}}

                    <button type="submit" class="btn btn-danger btn-xs">Delete</button>

                </form>

            @endcan

            @can('update' , $reply)

                <form method="POST" action="{{route('reply.edit',$reply)}}">

                    {{csrf_field()}}

                    {{method_field('PATCH')}}

                    <button type="submit" class="btn btn-default btn-xs">Edit</button>

                </form>

            @endcan
            
            @if(!$reply->isBest)
            
                @can('update' , $reply->thread)

                    <form method="POST" action="{{route('reply.best',$reply)}}" class="ml-a">

                        {{csrf_field()}}

                        <button type="submit" class="btn btn-default btn-xs">Best Reply ?</button>

                    </form>

                @endcan
            
            @endif

        </div>

    </div>
