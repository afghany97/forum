@extends('layouts.app')

@section('content')
<div class="container">

	<form method = "POST" action="/replies/{{$reply->id}}">
	
	    {{ csrf_field() }}

	    {{method_field('PUT')}}

		<div class="form-group">
		
			<label for="exampleInputPassword1">Reply body</label>
		
			<textarea name ="body" type="text" class="form-control" id="exampleInputPassword1" placeholder="reply body" required>{{$reply->body}}</textarea>
		
		</div>
		
		<button type="submit" class="btn btn-primary">update reply</button>
		
		@include('layouts.errors')

	</form>

</div>
@endsection