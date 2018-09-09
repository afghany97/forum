@if(auth()->check())

    @if($thread->IsFavourited())

        <div class="text-right flex" style="float:right;">

            <form method="POST" action="/threads/{{$thread->slug}}/unfavourite">

                {{csrf_field()}}

                {{method_field('DELETE')}}

                <button type="submit" class="btn btn-primary btn-xs">

                    {{$thread->favourites->count()}}

                    <i class="far fa-heart"></i>

                </button>

            </form>

        </div>

    @else

    <div class="text-right flex" style="float:right;">

        <form method="POST" action="/threads/{{$thread->slug}}/favourite">

            {{csrf_field()}}

            <button type="submit" class="btn btn-default btn-xs">

                {{$thread->favourites->count()}}

                <i class="fas fa-heart"></i>

{{--                {{str_plural('Favourite' , $thread->favourites->count())}}--}}

            </button>                        

        </form>

    </div>

    @endif

@endif