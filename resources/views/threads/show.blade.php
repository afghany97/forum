@extends('layouts.app')

@section('content')
                    
    @include('threads.head')
        
    @include('threads.body')

    @include('threads.delete')

    @foreach($replies as $Reply)

        @include('threads.reply')

    @endforeach

    {{$replies->links()}}

    @include('replies.create')

    @include('layouts.errors')

    @include('threads.rightSide')
    
@endsection
