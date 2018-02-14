@component('profiles.activites.activity')
	
	@slot('header')                        
    <a href="{{route('profile',$activity->User)}}">

        {{$activity->User->name}}</a> published  

        <a href="{{$activity->subject->path()}}"> {{$activity->subject->title}} </a>
                    
    @endslot

    @slot('body')

        {{$activity->subject->body}}

    @endslot

@endcomponent