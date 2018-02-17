            <div class="panel panel-default">

                <div class="panel-heading level" id="reply-{{$Reply->id}}">

                    <div>

                        
                    <a href="{{route('profile' , $thread->User)}}"> 

                        {{$Reply->User->name}}

                    </a>

                    From {{$Reply->created_at->diffForHumans()}}
                        
                    </div>

                    <div class="flex text-right">

                        <form method="POST" action="/replies/{{$Reply->id}}/favourite">

                            {{csrf_field()}}

                            <button type="submit" class="btn btn-primary" {{$Reply->IsFavourited() ? 'disabled' : ''}}>

                                {{$Reply->favourites->count()}} {{str_plural('Favourite' , $Reply->favourites->count())}}

                            </button>                        

                        </form>

                    </div> 
                
                </div>

                

                <div class="panel-body" >

                        {{$Reply->body}}

                  
                </div>
                
                @can('delete' , $Reply)
                
                <div class="panel-footer">
                    
                    <form method="POST" action="/replies/{{$Reply->id}}" style="float: left;" class="mr-1">
                        
                        {{csrf_field()}}

                        {{method_field('DELETE')}}

                        <button type="submit" class="btn btn-danger btn-xs">Delete</button>

                    </form>
                @endcan

                @can('update' , $Reply)

                <form method="POST" action="/replies/{{$Reply->id}}">
                    
                    {{csrf_field()}}

                    {{method_field('PATCH')}}

                    <button type="submit" class="btn btn-xs">Update</button>

                </form>
        
                </div>
                
                @endcan

            </div>
