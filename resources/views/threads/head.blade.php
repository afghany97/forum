<div class="container">

        <div class="row">
        
            <div class="col-md-8 ">
        
                <div class="panel panel-default">
        
                    <div class="panel-heading level">

                        <a href="{{route('profile' , $thread->User)}}">

                            {{$thread->User->name}}
                         
                        </a>
        
                         Posted ...
                        
                        {{$thread->title}}
                        
                        @include('threads.favourite')

                    </div>