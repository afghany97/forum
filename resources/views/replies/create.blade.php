@if( auth()->check() && $thread->is_locked && auth()->user()->confirmed)

    <p class="text-center">

      <strong>this thread was locked by a supervisor or administrator</strong>

    </p>

@elseif(auth()->check() && auth()->user()->confirmed)

    <form action="{{$thread->path() . '/replies'}}" method="POST">

	    {{csrf_field()}}

	    <textarea class="form-control" placeholder="leave a reply..." id="body" name="body" rows="4">{{old('body')}}</textarea>

	    <button type="submit" class="btn btn-defualt">Submit</button>

	</form>

@elseif(auth()->check() && !auth()->user()->confirmed)

    <p class="text-center">

            please confirm your email to be albe to reply to thread

    </p>

@else

    <p class="text-center">

        <a href="{{route('login')}}">

            Sign in

        </a>

        to be albe to reply to thread

    </p>

@endif
