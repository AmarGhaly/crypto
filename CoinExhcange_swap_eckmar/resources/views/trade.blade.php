@extends('master.main')


@section('content')
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card" style="margin-top: 15rem">
                <div class="card-header">
                    Trade {{$trade->id}}
                </div>
                <div class="card-body pl-0 pr-sm-0">
                    <div class="row">
                        <div class="col-md-4">
                            @include('includes.feedback')
                            <ul class="list-group ">
                                @foreach(\App\Trade::getPublicStates() as $state)
                                    <li class="list-group-item @if($trade->state == \App\Trade::getStateOriginalName($state)) list-group-item-primary @endif">
                                        {{$state}}
                                    </li>
                                @endforeach
                                @if($trade->state == 'refunded')
                                    <li class="list-group-item  list-group-item-primary ">
                                        Refunded
                                    </li>
                                @endif
                                    @if($trade->state == 'canceled')
                                        <li class="list-group-item  list-group-item-primary ">
                                            Canceled
                                        </li>
                                    @endif
                            </ul>
                        </div>
                        <div class="col-md-8">
                            @include('includes.trade-state',$trade)
                            <hr>
                            <p>
                                Expected return: {{$trade->expected_return}} {{strtoupper($trade->other_coin)}} <span class="text-muted small">(Not counting network fees)</span>
                            </p>
                            <p>
                                Address where {{strtoupper($trade->other_coin)}} will be sent after the trade:
                            </p>
                            <p class="text-muted">
                                {{$trade->morphTrade->output_address}}
                            </p>
                        </div>
                    </div>

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
