@extends('layouts.app'  )

@section('content')
<div class="container">

	<form method = "POST" action="/threads">
	
	    {{ csrf_field() }}
	
	    <div class="form-group">
		
			<label for="exampleInputEmail1">thread title</label>
		
			<input name = "title" type="text" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp" placeholder="post title" required>
		
		</div>

		<div class="form-group">
		
			<label for="exampleInputPassword1">thread body</label>
		
			<textarea name = "body" type="text" class="form-control" id="exampleInputPassword1" placeholder="post body"></textarea>
		
		</div>
		
		<button type="submit" class="btn btn-primary">create post</button>
	
	</form>

</div>
@endsection