
            <div class="panel panel-default">

                <div class="panel-heading">
                
                    <a href="#"> 

                        {{$Reply->User->name}}

                    </a>

                    From {{$Reply->created_at->diffForHumans()}}
                        
                </div>

                <div class="panel-body">

                        {{$Reply->body}}

                </div>

            </div>
