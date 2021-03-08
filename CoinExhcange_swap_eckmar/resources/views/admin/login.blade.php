@extends('master.main')

@section('content')

<div class="row justify-content-center mt-5">
    <div class="col col-md-4">
        @include('includes.feedback')
        <div class="card">
            <div class="card-header">
                Sign in
            </div>
            <div class="card-body">
                <form action="{{route('auth.login.post')}}" method="post">
                    @csrf
                    <div class="form-group">
                        <label for="username">Username:</label>
                        <input type="text" name="username" id="username" class="form-control">
                    </div>
                    <div class="form-group">
                        <label for="password">Password:</label>
                        <input type="password" name="password" id="password" class="form-control">
                    </div>
                    @include('includes.captcha')
                    <div class="form-group">
                        <button type="submit" class="btn btn-primary">Sign in </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@stop
