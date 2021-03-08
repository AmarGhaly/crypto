@extends('master.main')

@section('content')

    <div class="row justify-content-center mt-5 mb-5">
        <div class="col">
            @include('includes.feedback')
            <div class="card">
                <div class="card-header">
                    @yield('admin-title')
                </div>
                <div class="card-body">
                    @yield('admin-content')
                </div>
            </div>
        </div>
    </div>
@stop
