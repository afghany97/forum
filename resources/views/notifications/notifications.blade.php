<li class="dropdown">
                                    
    <a href="#" class="dropdown-toggle" data-toggle="dropdown">
        
        <span class="glyphicon glyphicon-bell"></span>
    </a>

    <ul class="dropdown-menu" role="menu">


    	@forelse($unreadNotifications as $notification)

        	<li><a href="{{$notification->data['link']}}">{{$notification->data['message']}}</a></li>

        @empty

        	<p>There is no new Notifications</p>

        @endforelse

        <hr>
        
    	<li><a href="/profiles/{{auth()->user()->name}}/notifications"}}>show all notifications</a></li>

    </ul>

</li>