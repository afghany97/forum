@extends('layouts.app')

@section('content')

    <div class="container">

        <form method="POST" action="{{$thread->path()}}/update">

            {{ csrf_field() }}

            {{method_field('PUT')}}

            <div class="form-group">

                <label for="exampleInputEmail1">thread title</label>

                <input name = "title" type="text" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp" placeholder="post title" value="{{old('title')? old('title')  : $thread->title }}" required>

            </div>

            <div class="form-group">

                <label for="exampleInputPassword1">thread body</label>

                <textarea name = "body" type="text" class="form-control" id="exampleInputPassword1" placeholder="post body" required>{{old('body')? old('body')  : $thread->body }}</textarea>

            </div>


            <button type="submit" class="btn btn-primary">update thread</button>

            @include('layouts.errors')

        </form>

    </div>

@endsection