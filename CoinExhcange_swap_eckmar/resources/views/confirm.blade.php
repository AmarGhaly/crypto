@extends('master.main')


@section('content')
    <div class="row justify-content-center">
        <div class="col-md-6">
            <div class="card" style="margin-top: 15rem; margin-bottom: 15rem">
                <div class="card-header">
                    Confirm trade
                </div>
                <div class="card-body">
                    @include('includes.feedback')
                    <p>
                        For <span class="text-warning">{{$details->requiredPayment}} {{strtoupper($details->baseCoin)}}</span> you will get approximately <span class="text-warning">{{$details->expectedReturn}} {{strtoupper($details->otherCoin)}}</span>
                    </p>

                    <form action="{{route('trade.create')}}" method="post">
                        @csrf
                        <div class="form-group">
                            <label for="receiving_address">Receiving address: ({{strtoupper($details->otherCoin)}})</label>
                            <input type="text" name="receiving_address" id="receiving_address" class="form-control" placeholder="{{strtoupper($details->otherCoin)}} address" value="{{old('receiving_address')}}">
                        </div>
                        <div class="form-group">
                            <label for="refund_address">Refund address: ({{strtoupper($details->baseCoin)}})</label>
                            <input type="text" name="refund_address" id="refund_address" class="form-control" placeholder="{{strtoupper($details->baseCoin)}} address" value="{{old('refund_address')}}">
                        </div>
                        <div class="form-group">
                            <button type="submit" class="btn btn-primary btn-block">Confirm trade</button>
                        </div>
                    </form>
                </div>
                <div class="card-footer">
                    <p class="text-muted small">
                        Please note that return values are not fixed, they are calculated at the moment of exchange
                    </p>
                </div>

            </div>
        </div>
    </div>
@stop
