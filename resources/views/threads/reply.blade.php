            <div class="panel panel-default">

                <div class="panel-heading" id="reply-{{$Reply->id}}">

                    <div class="level">

                            
                    <a href="{{route('profile' , $thread->User)}}"> 

                        {{$Reply->User->name}}

                    </a>

                    From {{$Reply->created_at->diffForHumans()}}
                        
                        

                    <div>

                        <form method="POST" action="/replies/{{$Reply->id}}/favourite">

                            {{csrf_field()}}

                            <button type="submit" class="btn btn-primary" {{$Reply->IsFavourited() ? 'disabled' : ''}}>

                                {{$Reply->favourites->count()}} {{str_plural('Favourite' , $Reply->favourites->count())}}

                            </button>                        

                        </form>

                    </div>

                    </div>
                
                </div> 

                <div class="panel-body" >

                        {{$Reply->body}}

                  
                </div>
                
                @can('delete' , $Reply)
                
                <div class="panel-footer">
                    
                    <form action="POST" action="/replies/{{$Reply->id}}">
                        
                        {{csrf_field()}}

                        {{method_field('DELETE')}}

                        <button type="submit" class="btn btn-danger btn-xs">Delete</button>

                    </form>

                </div>

                @endcan
            
            </div>
