@if($user->is_supervisor)

    <form action="/users/{{$user->name}}/supervisor" method="post">

        {{csrf_field()}}

        <button type="submit" class="btn btn-primary btn-xs">un-supervisor</button>

    </form>

@elseif($user->is_admin)

    administrator

@else

    <form action="/users/{{$user->name}}/supervisor" method="post">

        {{csrf_field()}}

        <button type="submit" class="btn btn-default btn-xs">supervisor</button>

    </form>

@endif