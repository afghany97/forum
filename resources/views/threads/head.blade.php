<div class="container">

        <div class="row">
        
            <div class="col-md-8 ">
        
                <div class="panel panel-default">
        
                    <div class="panel-heading level">

                        <a href="{{route('profile' , $thread->User)}}" class="mr-1">

                            <img src="/storage/{{$thread->User->avatar_path}}" alt="{{$thread->User->name}}" class="smallAvatar mr-5">
                            
                            {{$thread->User->name }}
                         
                        </a>

                         published ...

                        {{$thread->title}}
                        
                        @include('threads.favourite')

                    </div>