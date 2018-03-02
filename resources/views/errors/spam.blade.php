@extends('layouts.app')

@section('content')
   
    <div class="container">

        <div class="row">
            
            <div class="col-md-8 col-md-offset-2">
                
        		<div class="alert alert-danger text-center">
        			
        			{{$e->getMessage()}}
	        			
        		</div>

            </div>

        </div>

    </div>

@endsection