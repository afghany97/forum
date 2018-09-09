@extends('layouts.app')

@section('content')

    @include('threads.head')

    @include('threads.body')

    @include('threads.deleteAndUpdate')

    @foreach($replies as $Reply)

        @if($Reply->isBest)

            @include('replies.bestReply')

        @else

            @include('replies.reply')

        @endif

    @endforeach

    {{$replies->links()}}
    
    @include('replies.create')

    @include('layouts.errors')

    @if(auth()->check())

        @include('threads.rightSide')

    @endif

@endsection