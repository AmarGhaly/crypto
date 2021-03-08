@extends('master.admin')
@section('admin-title','Trades')
@section('admin-content')
    <div class="row">
        <div class="col">
            @foreach($profit as $coin => $profitFromCoin)
                <p>
                    {{strtoupper($coin)}}: {{$profitFromCoin}}
                </p>
            @endforeach
        </div>
    </div>
    <div class="row">
        <div class="col">
            <form action="{{route('admin.trade.filter')}}" method="post">
                @csrf
                <div class="form-group mr-1">
                    <label for="search_param" class="mr-2">Search parameter:</label>
                    <select name="search_param" id="search_param" class="form-control">
                        @foreach($validParams as $validParam)
                            <option value="{{$validParam}}" @if($validParam == $param) selected @endif >{{$validParam}}</option>
                        @endforeach
                    </select>
                </div>
                <div class="form-group mr-1">
                    <label for="search_query" class="mr-2">Search query:</label>
                    <input type="text" name="search_query" id="search_query" class="form-control" value="{{$query}}">
                </div>
                <div class="form-group mr-1">
                    <button type="submit" class="btn btn-primary">Search</button>
                </div>
                <div class="form-group">
                    <a href="{{route('admin.index')}}" class="btn btn-secondary"> Clear query</a>
                </div>
            </form>
        </div>
    </div>
    <div class="row">
        <div class="col">
            <p>
                @if($query !== '' && $param !== '')
                    Displaying total of {{count($trades)}} {{\Illuminate\Support\Str::plural('trade',count($trades))}} that mach query [ {{$query}} ] by parameter [ {{$param}} ]
                @else
                    Currently displaying all trades
                @endif
            </p>

        </div>
    </div>
    <div class="row">
        <div class="col">
            <table class="table">
                <thead>
                <th>
                    ID
                </th>
                <th>
                    Trade Direction
                </th>
                <th>
                    Amount
                </th>
                <th>
                    State
                </th>
                <th>
                    Action
                </th>
                </thead>
                <tbody>
                    @foreach($trades as $trade)
                        <tr>
                            <td>
                                {{$trade->id}}
                            </td>
                            <td>
                                {{strtoupper($trade->base_coin)}} -> {{strtoupper($trade->other_coin)}}
                            </td>
                            <td>
                                {{$trade->required_payment}}
                            </td>
                            <td>
                                {{\App\Trade::getStateFriendlyName($trade->state)}}
                            </td>
                            <td>
                                <a href="{{route('admin.trade',$trade)}}">Details</a>
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
                Displaying up to {{$tradesPerPage}} trades per page
            </p>
        </div>
    </div>
    <div class="row">
        <div class="col">
            {{$trades->links()}}
        </div>
    </div>

@stop
