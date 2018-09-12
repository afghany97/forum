@extends('layouts.app')

@section('content')

    <div class="row">

        @forelse($history as $modify)

            <div class="col-md-6">

                <div class="panel panel-danger">

                    <div class="panel-heading level">

                        @if(isset(json_decode($modify->before)->title))

                            {{json_decode($modify->before)->title}}

                        @endif

                    </div>

                    <div class="panel-body">

                        <div class="body">

                            @if(isset(json_decode($modify->before)->body))

                                {{json_decode($modify->before)->body}}

                            @endif

                        </div>

                    </div>

                </div>

            </div>

            <div class="col-md-6">

                <div class="panel panel-success">

                    <div class="panel-heading level">

                        @if(isset(json_decode($modify->after)->title))

                            {{json_decode($modify->after)->title}}

                        @endif

                    </div>

                    <div class="panel-body">

                        <div class="body">

                            @if(isset(json_decode($modify->after)->body))

                                {{json_decode($modify->after)->body}}

                            @endif

                        </div>

                    </div>

                </div>

            </div>

        @empty

            <h1>This thread didn't updated yet</h1>

        @endforelse

    </div>

@endsection