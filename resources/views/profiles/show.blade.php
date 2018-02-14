@extends('layouts.app')

@section('content')
   
    <div class="container">


        <div class="row">
            
            <div class="col-md-8 col-md-offset-2">
                
        @foreach($activites as $date => $records)

        	<h1> {{$date}} </h1>

        	@foreach($records as $activity)

            	@include("profiles.activites.{$activity->type}")
        	
        	@endforeach

        @endforeach

            </div>

        </div>

    </div>

@endsection
