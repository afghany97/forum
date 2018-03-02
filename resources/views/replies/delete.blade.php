@can('delete' , $Reply)
    
    <div class="panel-footer">
        
        <form method="POST" action="/replies/{{$Reply->id}}" style="float: left;" class="mr-1">
            
            {{csrf_field()}}

            {{method_field('DELETE')}}

            <button type="submit" class="btn btn-danger btn-xs">Delete</button>

        </form>

    
@endcan