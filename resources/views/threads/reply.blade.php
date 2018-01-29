<div class="row">
        <div class="col-md-8 col-md-offset-2">

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

        </div>
</div>
    