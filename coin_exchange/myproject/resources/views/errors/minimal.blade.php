@extends('master.main')


@section('content')
    <div class="row justify-content-center">
        <div class="col-md-6">
            <div class="card" style="margin-top: 15rem">
                <div class="card-header">
                    @yield('code')
                </div>
                <div class="card-body">
                    @yield('message')
                </div>
            </div>
        </div>
    </div>
@stop


