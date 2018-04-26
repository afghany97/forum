@if($status)

    @if($Reply->IsFavourited())

        <div class="flex text-right">

            <form method="POST" action="/replies/{{$Reply->id}}/unfavourite">

                {{csrf_field()}}

                {{method_field("DELETE")}}
                <button type="submit" class="btn btn-primary btn-xs">

                    {{$Reply->favourites->count()}}

                    <i class="far fa-heart"></i>

                </button>

            </form>

        </div>

    @else

        <div class="flex text-right">

            <form method="POST" action="/replies/{{$Reply->id}}/favourite">

                {{csrf_field()}}

                <button type="submit" class="btn btn-default btn-xs">

                    {{$Reply->favourites->count()}}

                    <i class="fas fa-heart"></i>

                </button>

            </form>

        </div>

    @endif

@endif