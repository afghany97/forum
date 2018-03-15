<div class="panel panel-default">

    <div class="panel-heading level" id="reply-{{$Reply->id}}">

        <div>
            
        <a href="{{route('profile' , $thread->User)}}"> 

            {{$Reply->User->name}}

        </a>

        From {{$Reply->created_at->diffForHumans()}}
            
        </div>

        @include('replies.favourite')
    
    </div>

    <div class="panel-body" >

            {{$Reply->body}}
      
    </div>
    
    @include('replies.delete')

    @include('replies.updateForm')

</div>