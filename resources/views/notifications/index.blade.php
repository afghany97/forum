@extends('layouts.app')

@section('content')

	@forelse($notifications as $notification)

	    <div class="container">

		   <div class="panel panel-default">
	        
	            <div class="panel-heading">

	        		<a href="{{$notification->data['link']}}">{{$notification->data['message']}}</a>
	            
	            </div>
	            
	        </div>

	    </div>

	@empty

		<p>There is no notifications</p>

	@endforelse

@endsection