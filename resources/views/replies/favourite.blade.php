@if(auth()->check())

            <div class="flex text-right">

                <form method="POST" action="/replies/{{$Reply->id}}/favourite">

                    {{csrf_field()}}

                    <button type="submit" class="btn btn-primary btn-xs" {{$Reply->IsFavourited() ? 'disabled' : ''}}>

                        {{$Reply->favourites->count()}} {{str_plural('Favourite' , $Reply->favourites->count())}}

                    </button>                        

                </form>

            </div> 

        @endif