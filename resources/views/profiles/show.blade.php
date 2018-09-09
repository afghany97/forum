@extends('layouts.app')

@section('content')
   
    <div class="container">

        <div class="row">

            <h1>{{$profileUser->name}}</h1>

            @if($profileUser->is_supervisor)

                <h4>Supervisor</h4>

            @endif

            @if($profileUser->is_admin)

                <h4>administrator</h4>

            @endif

            <div>

                <img src="/storage/{{$profileUser->avatar_path}}" alt="{{$profileUser->name}}" class="avatar mb-10">

            </div>
            
            @can('create' , $profileUser)

                <form method="POST" action="{{route('avatar',$profileUser)}}" enctype="multipart/form-data">
                    
                    {{ csrf_field() }}

                    <input type="file" name="avatar" class="mb-10">

                    <button type="submit" class="btn btn-primary" >Add Avatar</button>

                </form>

            @endcan
            
            <div class="col-md-8 col-md-offset-2">
                
        @forelse($activites as $date => $records)

        	<h1> {{$date}} </h1>

        	@foreach($records as $activity)

{{--                {{dd($records)}}--}}
            	@include("profiles.activites.{$activity->type}")

        	@endforeach

        @empty

            <p>There is no activites for this user yet.</p>

        @endforelse

            </div>

        </div>

    </div>

@endsection
