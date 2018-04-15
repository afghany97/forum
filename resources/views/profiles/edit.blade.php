@extends('layouts.app')

@section('content')

    <div class="container">

        <form method="POST" action="{{route('profile-update' , $user)}}">

            {{ csrf_field() }}

            {{method_field('PUT')}}

            <div class="form-group">

                <label for="exampleInputEmail1">name</label>

                <input name ="name" type="text" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp" placeholder="name" value="{{old('name')? old('name')  : $user->name}}">

            </div>

            <button type="submit" class="btn btn-primary">update profile</button>

            @include('layouts.errors')

        </form>

    </div>

@endsection