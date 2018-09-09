@if(auth()->check())

    <div class="panel-footer level">

        @can('delete',$thread)


            <form method="POST" action="{{$thread->path()}}" class="mr-5">

                {{csrf_field()}}

                {{method_field('DELETE')}}

                <button type="submit" class="btn btn-danger btn-xs">Delete Thread</button>

            </form>

            <form method="POST" action="{{$thread->path()}}/edit">

                {{csrf_field()}}

                {{method_field('patch')}}

                <button type="submit" class="btn btn-default btn-xs">Update Thread</button>

            </form>

        @endcan

        <form action="/threads/{{$thread->slug}}/update/history" method="POST" class="ml-a">

            {{csrf_field()}}

            <button type="submit" class="btn btn-default btn-xs">Update History</button>


        </form>

    </div>

    </div>

@endif