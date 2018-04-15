</div>
</div>

<div class="col-md-4">

    <p>

        This thread was published from {{$thread->created_at->diffForHumans()}}

        by <a href="{{route('profile' , $thread->User)}}"> {{$thread->User->name}} </a> and currently
        has {{$thread->replies_count}}

        {{str_plural('comment',$thread->replies_count)}}

    </p>

</div>

@include('threads.subscribe')

@if((auth()->check() && $authUser->is_supervisor) || $authUser->is_admin)

@include('threads.lock')

@endif
</div>

</div>

</div>  