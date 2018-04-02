<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Styles -->
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    <link href="{{ asset('fonts/font-awesome.min.css') }}" rel="stylesheet">
    {{--<link href="https://maxcdn.bootstrapcdn.com/font-awesome/4.6.3/css/font-awesome.min.css" rel="stylesheet">--}}

</head>
<body>
    <div id="app">
        <nav class="navbar navbar-default navbar-static-top">
            <div class="container">
                <div class="navbar-header">

                    <!-- Collapsed Hamburger -->
                    <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#app-navbar-collapse">
                        <span class="sr-only">Toggle Navigation</span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                    </button>

                    <!-- Branding Image -->
                    <a class="navbar-brand" href="{{ url('/') }}">
                        {{ config('app.name', 'Laravel') }}
                    </a>
                </div>

                <div class="collapse navbar-collapse" id="app-navbar-collapse">
                    <!-- Left Side Of Navbar -->
                    <ul class="nav navbar-nav">
                        &nbsp;
                                                
                        <li class="nav-item dropdown">
                        
                            <a class="nav-link dropdown-toggle" href="http://example.com" id="navbarDropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        
                              Browse
                        
                            </a>
                        
                            <div class="dropdown-menu" aria-labelledby="navbarDropdownMenuLink">
                            
                                <a class="dropdown-item" href="{{ route('threads') }}">All Threads</a>
                                
                                <a class="dropdown-item" href="/threads?populair=1">Populair Threads</a>
                                
                                <a class="dropdown-item" href="/threads?unanswered=1">Unanswered Threads</a>

                                @if(auth()->checK())

                                    <a class="dropdown-item" href="/threads?by={{auth()->user()->name}}">My Threads</a>
                            
                                @endif

                            </div>

                        </li>

                        <li class="nav-item dropdown">
                        
                            <a class="nav-link dropdown-toggle" href="http://example.com" id="navbarDropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        
                              Channels
                        
                            </a>
                        
                            <div class="dropdown-menu" aria-labelledby="navbarDropdownMenuLink">
                            
                            @foreach($channels as $channel)     

                              <a class="dropdown-item" href="/threads/{{$channel->name}}">{{$channel->name}}</a>
                            
                            @endforeach

                            </div>

                        </li>
                            
                            

                        @if(auth()->check())

                            <li><a href="\threads\create">New Thread</a></li>
                            
                        @endif

                    </ul>

                    <!-- Right Side Of Navbar -->
                    <ul class="nav navbar-nav navbar-right">
                        <!-- Authentication Links -->
                        @if (Auth::guest())
                            <li><a href="{{ route('login') }}">Login</a></li>
                            <li><a href="{{ route('register') }}">Register</a></li>
                        @else
                            
                            @include('notifications.notifications')

                            <li class="dropdown">
                                <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false">
                                    {{ Auth::user()->name }} <span class="caret"></span>
                                </a>

                                <ul class="dropdown-menu" role="menu">

                                    <li>

                                        <a href="{{route('profile' , auth()->user())}}">My Profile

                                            @if(Auth::user()->confirmed)

                                                <i class="fas fa-check"></i>

                                            @else

                                                <i class="fas fa-times"></i>

                                            @endif

                                        </a>

                                    </li>

                                    <li>
                                        <a href="{{ route('logout') }}"
                                            onclick="event.preventDefault();
                                                     document.getElementById('logout-form').submit();">
                                            Logout
                                        </a>

                                        <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                                            {{ csrf_field() }}
                                        </form>
                                    </li>
                                </ul>
                            </li>
                        @endif
                    </ul>
                </div>
            </div>
        </nav>
        @if(session('message'))
        
        <div class="alert alert-success text-center" role="alert">
        
            {{session('message')}}
        
        </div>
        
        @endif
        
        @yield('content')
    </div>

    <!-- Scripts -->
    <script src="{{ asset('js/app.js') }}"></script>
    {{--<style type="text/css">--}}
        {{--.level {display: flex; align-items: center;}--}}
        {{--.flex {flex: 1;}.mr-1 { margin-right: 1em;  }--}}
        {{--.avatar{border-radius: 50%; width:100px; height: 100px;}--}}
        {{--.smallAvatar {border-radius: 50% ; width: 25px ; height: 25px}--}}
        {{--.mb-1{margin-bottom: 1px}--}}
        {{--.mb-5{margin-bottom: 5px}--}}
        {{--.mb-10{margin-bottom: 10px}--}}
        {{--.mr-5{margin-right: 5px}--}}
    {{--</style>--}}
</body>
</html>
