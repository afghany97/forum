@if( $status && $thread->is_locked && $authUser->confirmed)

    <p class="text-center">

      <strong>this thread was locked by a supervisor or administrator</strong>

    </p>

@elseif($status && $authUser->confirmed)

    <form action="{{$thread->path() . '/replies'}}" method="POST">

	    {{csrf_field()}}

	    <textarea class="form-control" placeholder="leave a reply..." id="body" name="body" rows="4">{{old('body')}}</textarea>

	    <button type="submit" class="btn btn-defualt">Submit</button>

	</form>

@elseif($status && !$authUser->confirmed)

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
