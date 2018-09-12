@extends('layouts.app')

@section('content')

    <form method="POST" action="{{$thread->path()}}/update">

        {{ csrf_field() }}

        {{method_field('PUT')}}

        <div class="form-group">

            <label for="title">Thread Title</label>

            <input name = "title" type="text" class="form-control" id="title" aria-describedby="emailHelp" placeholder="post title" value="{{old('title')? old('title')  : $thread->title }}" required>

        </div>

        <div class="form-group">

            <label for="body">Thread Body</label>

            <textarea name = "body" type="text" class="form-control" id="body" placeholder="post body" required>{{old('body')? old('body')  : $thread->body }}</textarea>

        </div>


        <button type="submit" class="btn btn-success">Update Thread</button>

        @include('layouts.errors')

    </form>

@endsection