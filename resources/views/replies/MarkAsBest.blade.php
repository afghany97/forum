@if(!$Reply->isBest)

    @can('update' , $Reply->thread)

        <form method="POST" action="/replies/{{$Reply->id}}/best" class="ml-a">

            {{csrf_field()}}

            <button type="submit" class="btn btn-default btn-xs ml-a">Best Reply ?</button>

        </form>

    @endcan
@endif

