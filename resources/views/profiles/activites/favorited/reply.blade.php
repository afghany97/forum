@component('profiles.activites.activity')
	
	@slot('header')                        
    
        <a href="{{route('profile',$activity->User)}}">

        {{$activity->User->name}}</a> favorited to reply on this thread

		<a href="{{$activity->subject->favorited->path()}}">{{$activity->subject->favorited->thread->title}}</a>                  
  
    @endslot

    @slot('body')

        {{$activity->subject->favorited->thread->body}}

    @endslot

@endcomponent