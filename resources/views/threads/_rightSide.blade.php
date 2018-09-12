
<p>

    This thread was published from {{$thread->created_at->diffForHumans()}}

    by <a href="{{route('profile' , $thread->User)}}"> {{$thread->User->name}} </a> and currently
    has {{$thread->replies_count}}

    {{str_plural('comment',$thread->replies_count)}}

</p>

@if($thread->isSubscribed)

    <div class="text-center">

        <form method="POST" action="{{route('thread.subscribe',[$thread->channel,$thread])}}">

            {{method_field('DELETE')}}

            {{csrf_field()}}

            <button class="btn btn-primary">Unsubscribe</button>

        </form>

    </div>

@else

    <div class="text-center">

        <form method="POST" action="{{route('thread.unsubscribe',[$thread->channel,$thread])}}">

            {{csrf_field()}}

            <button class="btn btn-defualt">Subscribe</button>

        </form>

    </div>

@endif