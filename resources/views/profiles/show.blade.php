@extends('layouts.app')

@section('content')

    <div class="row">

        <h1>{{$profileUser->name}}</h1>

        @if($profileUser->is_supervisor)

            <h4>Supervisor</h4>

        @endif

        @if($profileUser->isAdmin())

            <h4>administrator</h4>

        @endif

        <div>

            <img src="{{$profileUser->avatarPath()}}" alt="{{$profileUser->name}}" class="avatar mb-10">

        </div>
        
        @can('update' , $profileUser)

            <form method="POST" action="{{route('avatar',$profileUser)}}" enctype="multipart/form-data">
                
                {{ csrf_field() }}

                <input type="file" name="avatar" class="mb-10">

                <button type="submit" class="btn btn-default" >Add Avatar</button>

            </form>

        @endcan
        
        <div class="col-md-8 col-md-offset-2">
            
    @forelse($activites as $date => $records)

        <h1> {{$date}} </h1>

        @foreach($records as $activity)

            @include("profiles.activites.{$activity->type}")

        @endforeach

    @empty
    
        <div class="text-center">

            <strong>This user has no activities yet.</strong>

        </div>

    @endforelse

        </div>

    </div>

@endsection
