@component('profiles.activites.activity')
	
	@slot('header')                        
    
        <a href="{{route('profile',$activity->User)}}">

        {{$activity->User->name}}</a> replied to 

        <a href="{{$activity->subject->Thread->path()}}"> {{$activity->subject->Thread->title}} </a>
                    
    @endslot

    @slot('body')

        {{$activity->subject->body}}

    @endslot

@endcomponent