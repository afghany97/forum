@extends('layouts.app'  )

@section('content')

    <div class="container">

        <div class="row">

            @include('admin._panel')

            <div class="col-md-11">

                <table border="1">

                    <tr>

                        <th class="text-center">thread owner</th>

                        <th class="text-center">title</th>

                        <th class="text-center">body</th>

                        <th class="text-center">Channel</th>

                        <th class="text-center">replies</th>

                        <th class="text-center">visits</th>

                        <th class="text-center">favourites</th>

                        <th class="text-center">status</th>

                        <th class="text-center">action</th>

                        <th class="text-center">best reply</th>

                    </tr>

                    @forelse($threads as $thread)

                        <tr>

                            <td class="text-center">

                                <a href="{{route('profile',$thread->user)}}">

                                    {{$thread->user->name}}

                                </a>

                            </td>

                            <td class="text-center">

                                <a href="{{$thread->path()}}">

                                    {{$thread->title}}

                                </a>

                            </td>

                            <td class="text-center">{{$thread->body}}</td>

                            <td class="text-center" width="50px">{{$thread->channel->name}}</td>

                            <td class="text-center" width="50px">{{$thread->replies_count}}</td>

                            <td class="text-center" width="50px">{{count(\App\ThreadsVistores::ThreadVists($thread))}}</td>

                            <td class="text-center" width="50px">{{$thread->favourites->count()}}</td>

                            <td class="text-center">

                                @include('threads.lock')

                            </td>

                            <td class="text-center">

                                <form action="{{$thread->path()}}" method="post">

                                    {{csrf_field()}}

                                    {{method_field('delete')}}

                                    <button type="submit" class="btn btn-danger btn-xs">Delete</button>

                                </form>
                                
                            </td>
                            
                            <td class="text-center" width="50px">

                                @if(!$thread->best_reply_id)

                                    there is no best reply selected

                                @else

                                    <a href="{{$thread->path() . "#reply-" . $thread->best_reply_id}}">Best Reply</a>

                                @endif

                            </td>

                        </tr>

                    @empty

                        <strong>there is no threads</strong>

                    @endforelse

                </table>

                {{$threads->links()}}

            </div>

        </div>

    </div>

@endsection