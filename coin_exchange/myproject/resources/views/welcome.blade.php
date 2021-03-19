@extends('master.main')


@section('content')
    <div class="row justify-content-center">
        <div class="col-md-6">
            <div class="card" style="margin-top: 10rem;margin-bottom: 15rem">
                <div class="card-body">
                    @include('includes.feedback')
                    @if($direction == 'btcxmr')
                    <h4>
                            Exchange Monero to Bitcoin
                        </h4>
                        <p>
                            1 Bitcoin = <span class="text-warning">{{\App\Coins\Converter::btcToXmr(1)}} Monero</span>
                        </p>
                        <form form action="{{route('trade.confirm.post')}}" method="post">
                            You send 
                            <input type="number" name="amount" id="amount_send" class="form-control"  placeholder="BTC Amount"><br>
                            You receive
                            <input type="number" name="amount" id="amount_receive" class="form-control"  placeholder="XMR Amount"><br>
                            Enter your ETH wallet adress
                            <input type="text" name="recipient" id="recipient" class="form-control"  placeholder="0x4........."><br>
                            <button type="submit" >Exchange</button>
                        </form>
                    @elseif($direction == 'xmrbtc')
                        <h4>
                            Exchange Monero to Bitcoin
                        </h4>
                        <p>
                            1 Monero  = <span class="text-warning">{{\App\Coins\Converter::xmrToBtc(1)}} Bitcoin</span>
                        </p>
                        <form form action="{{route('trade.confirm.post')}}" method="post">
                            You send 
                            <input type="number" name="amount" id="amount_send" class="form-control"  placeholder="XMR Amount"><br>
                            You receive
                            <input type="number" name="amount" id="amount_receive" class="form-control"  placeholder="BTC Amount"><br>
                            Enter your ETH wallet adress
                            <input type="text" name="recipient" id="recipient" class="form-control"  placeholder="0x4........."><br>
                            <button type="submit" >Exchange</button>
                        </form>
                    @endif
                        <!-- <form action="{{route('trade.confirm.post')}}" method="post">
                            @csrf
                            
                            <input type="hidden" name="direction" value="{{$direction}}">
                            <div class="form-group">
                                <input type="number" name="amount" id="amount" class="form-control" placeholder="Amount" step="any">
                            </div>
                            <div class="form-group">
                                <button type="submit" class="btn btn-block btn-primary">Convert</button>
                            </div>
                        </form> -->
                </div>

                <div class="card-footer">
                    <a href="{{$otherDirection}}" class="text-decoration-none text-white">Looking to convert @if($direction == 'btcxmr') XMR @elseif($direction == 'xmrbtc') BTC @else BTC @endif ?</a>
                </div>
            </div>
        </div>
    </div>
@stop
