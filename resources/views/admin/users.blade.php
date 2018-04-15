@extends('layouts.app'  )

@section('content')

    <div class="container">

        <div class="row">

            @include('admin._panel')

            <div class="col-md-11">

                <table border="1">

                    <tr>

                        <th class="text-center">name</th>

                        <th class="text-center">E-mail</th>

                        <th class="text-center">threads</th>

                        <th class="text-center">replies</th>

                        <th class="text-center">status</th>

                        <th class="text-center">Role</th>

                        <th class="text-center">member since</th>

                    </tr>

                    @forelse($users as $user)

                        <tr>

                            <td class="text-center">

                                <a href="{{route('profile' , $user)}}">

                                    {{$user->name}}

                                </a>

                            </td>

                            <td class="text-center">{{$user->email}}</td>

                            <td class="text-center" width="50px">{{$user->Threads()->count()}}</td>

                            <td class="text-center" width="50px">{{$user->Replies()->count()}}</td>

                            <td class="text-center" width="100px">

                                @if(!$user->confirmed)

                                    <a href="/register/confirm/{{$user->confirmation_token}}">Confirm</a>

                                @else

                                    confirmed

                                @endif
                            </td>

                            <td class="text-center">

                                @include('admin._supervisor')

                            </td>

                            <td class="text-center" width="100px">{{$user->created_at->diffForHumans()}}</td>

                        </tr>

                    @empty

                        <strong>there is no users</strong>

                    @endforelse

                </table>

                {{$users->links()}}

            </div>

        </div>

    </div>

@endsection