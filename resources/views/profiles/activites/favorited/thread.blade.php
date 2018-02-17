@component('profiles.activites.activity')
	
	@slot('header')                        
    <a href="{{route('profile',$activity->User)}}">

        {{$activity->User->name}}</a> favorited to this thread

		<a href="{{$activity->subject->favorited->path()}}">{{$activity->subject->favorited->title}}</a>
    @endslot

    @slot('body')

        {{$activity->subject->favorited->body}}

    @endslot

@endcomponent