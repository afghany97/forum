<li class="dropdown">
                                    
    <a href="#" class="dropdown-toggle" data-toggle="dropdown">
        
        <i class="fas fa-bell"></i>

    </a>

    <ul class="dropdown-menu" role="menu">

    	@forelse($unreadNotifications as $notification)

        	<li><a href="{{$notification->data['link']}}">{{$notification->data['message']}}</a></li>

        @empty

        	<p>There is no new Notifications</p>

        @endforelse

        <hr>
        
    	<li><a href="{{route('user.notifications',auth()->user())}}"}}>show all notifications</a></li>

    </ul>

</li>