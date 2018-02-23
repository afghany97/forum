@if($thread->isSubscribed)

                <div>
                        
                    <form method="POST" action="{{$thread->path() . '/subscribe'}}">
                            
                            {{method_field('DELETE')}}

                            {{csrf_field()}}

                            <button class="btn btn-primary">Unsubscribe</button>

                    </form>

                </div>

            @else
            
                <div>
                        
                    <form method="POST" action="{{$thread->path() . '/subscribe'}}">
                            
                            {{csrf_field()}}

                            <button class="btn btn-defualt">Subscribe</button>

                    </form>

                </div>

            @endif