@can('delete',$thread)

    <div class="panel-footer">
    
        <form method="POST" action="{{$thread->path()}}">
            
            {{csrf_field()}}

            {{method_field('DELETE')}}

            <button type="submit" class="btn btn-danger btn-xs">Delete Thread</button>

        </form>

    </div>
                </div>
                   
@endcan