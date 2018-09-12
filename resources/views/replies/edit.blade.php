@extends('layouts.app')

@section('content')

	<form method = "POST" action="/replies/{{$reply->id}}">

		{{ csrf_field() }}

		{{method_field('PUT')}}

		<div class="form-group">
		
			<label for="body">Reply Body</label>
		
			<textarea name ="body" type="text" class="form-control" id="body" placeholder="reply body" required>{{$reply->body}}</textarea>
		
		</div>
		
		<button type="submit" class="btn btn-success">Update Reply</button>
		
		@include('layouts.errors')

	</form>

@endsection