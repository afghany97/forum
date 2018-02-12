            <div class="panel panel-default">

                <div class="panel-heading">

                    <div class="level">

                            
                    <a href="#"> 

                        {{$Reply->User->name}}

                    </a>

                    From {{$Reply->created_at->diffForHumans()}}
                        
                        

                    <div>

                        <form method="POST" action="/replies/{{$Reply->id}}/favourite">

                            {{csrf_field()}}

                            <button type="submit" class="btn btn-primary" {{$Reply->isFavourited() ? 'disabled' : ''}}>{{$Reply->favourites_count}} 

                                {{str_plural('Favourite' , $Reply->favourites_count)}}</button>                        

                        </form>

                    </div>

                    </div>
                
                </div> 

                <div class="panel-body">

                        {{$Reply->body}}

                  
                </div>

            </div>
