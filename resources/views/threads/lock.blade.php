@if($thread->is_locked)

    <form action="/threads/{{ $thread->slug }}/lock" method="post">

        {{csrf_field()}}

        {{method_field('put')}}

        <button type="submit" class="btn btn-default"> unlock</button>

    </form>

@else

    <form action="/threads/{{ $thread->slug }}/lock" method="post">

        {{csrf_field()}}

        {{method_field('put')}}

        <button type="submit" class="btn btn-danger">lcok</button>

    </form>


@endif

