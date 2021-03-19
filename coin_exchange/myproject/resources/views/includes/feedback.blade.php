
@if(session()->has('error'))
    <div id="error" class="alert alert-danger text-center">
        {{ session()->get('error') }}
    </div>
@endif
@if(session()->has('success'))
    <div class="alert alert-success my-2 text-center">
        {{session()->get('success')}}
    </div>
@endif
@if(count($errors) > 0)
    <div class="alert alert-danger">
        <p class="alert-heading">
            Form is invalid
        </p>
        <ul>
            @foreach($errors -> all() as $error)
                <li>
                    {{ $error }}
                </li>
            @endforeach
        </ul>
    </div>

@endif

