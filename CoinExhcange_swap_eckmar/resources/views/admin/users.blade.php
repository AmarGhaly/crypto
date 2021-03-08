@extends('master.admin')
@section('admin-title','Trades')
@section('admin-content')


    <div class="row">
        <div class="col">
            <table class="table">
                <thead>
                <th>
                    ID
                </th>
                <th>
                    Username
                </th>
                <th>
                    Registration Date
                </th>

                </thead>
                <tbody>
                @foreach($users as $user)
                    <tr>
                       <td>
                           {{$user->id}}
                       </td>
                        <td>
                            {{$user->username}}
                        </td>
                        <td>
                            {{$user->created_at}} ({{$user->created_at->diffForHumans()}})
                        </td>
                    </tr>
                @endforeach
                </tbody>
            </table>
        </div>
    </div>
    <div class="row">
        <div class="col">
            <p class="text-muted">
                Displaying up to {{$usersPerPage}} users per page
            </p>
        </div>
    </div>
    <div class="row">
        <div class="col">
            {{$users->links()}}
        </div>
    </div>

@stop
