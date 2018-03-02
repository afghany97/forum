@if(auth()->check())

    <div class="text-right flex" style="float:right;">

        <form method="POST" action="/threads/{{$thread->id}}/favourite">

            {{csrf_field()}}

            <button type="submit" class="btn btn-primary btn-xs" {{$thread->IsFavourited() ? 'disabled' : ''}}>

                {{$thread->favourites->count()}} {{str_plural('Favourite' , $thread->favourites->count())}}

            </button>                        

        </form>

    </div>
                        
@endif