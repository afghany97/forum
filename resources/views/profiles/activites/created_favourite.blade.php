@component('profiles.activites.activity')
	
	@slot('header')                        
    <a href="{{route('profile',$activity->User)}}">

        {{$activity->User->name}}</a> favorited to 

		{{get_class($activity)}}                    
    @endslot

    @slot('body')

        {{$activity->subject->body}}

    @endslot

@endcomponent