@can('delete' , $Reply)


        <form method="POST" action="/replies/{{$Reply->id}}" class="mr-1 fl">

            {{csrf_field()}}

            {{method_field('DELETE')}}

            <button type="submit" class="btn btn-danger btn-xs">Delete</button>

        </form>

@endcan
