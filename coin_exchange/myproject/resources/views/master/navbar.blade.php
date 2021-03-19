<div class="container">
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
        <a class="navbar-brand" href="{{route('home')}}">{{config('app.name')}}</a>
        @auth
        <ul class="navbar-nav ml-auto">
            <li class="nav-item active">
                <a class="nav-link" href="{{route('admin.index')}}">Trades </a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="{{route('admin.users')}}">Users</a>
            </li>
            <li class="nav-item">
                <form action="{{route('auth.logout')}}" method="post">
                    @csrf
                    <button type="submit" class="btn btn-secondary">Log out</button>
                </form>
            </li>
        </ul>
        @endauth
    </nav>
</div>
