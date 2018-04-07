@can('update' , $Reply)


    <form method="POST" action="/replies/{{$Reply->id}}">

        {{csrf_field()}}

        {{method_field('PATCH')}}

        <button type="submit" class="btn btn-xs">Update</button>

    </form>


@endcan

