@extends('layouts.app')

@section('content')
   
    <div class="container">


        <div class="row">
            
            <div class="col-md-8 col-md-offset-2">
                
                <div class="page-headr">
            
            <h1>
                {{$profileUser->name}}

                <small> Since {{$profileUser->created_at->diffForHumans()}} </small>

            </h1>

        </div>

        @foreach($threads as $thread)

            <div class="panel panel-default">

                <div class="panel-heading">

                    <a href="{{route('profile',$profileUser)}}">
                        
                        {{$thread->User->name}}</a> posted :

                        <a href="{{$thread->path()}}"> {{$thread->title}} </a>
                        
                        <div class="text-right">

                            {{$thread->created_at->diffForHumans()}}
                        
                        </div>
                </div>


                <div class="panel-body">
                            
                    <div class="body">

                        {{$thread->body}}

                    </div>
        
                </div>

            </div>

        @endforeach

        {{$threads->links()}}

    </div>

            </div>    

        </div>
        

@endsection
