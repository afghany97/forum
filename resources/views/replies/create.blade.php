@if(auth()->check())

    <form action="{{$thread->path() . '/replies'}}" method="POST">

	    {{csrf_field()}}
	    
	    <textarea class="form-control" placeholder="leave a reply..." id="body" name="body" rows="4"></textarea>

	    <button type="submit" class="btn btn-defualt">Submit</button>

	</form>
@else

    <p class="text-center">

        <a href="{{route('login')}}">

            Sign in
    
        </a>
        
         to be albe to reply to thread
        
    </p>   

@endif
