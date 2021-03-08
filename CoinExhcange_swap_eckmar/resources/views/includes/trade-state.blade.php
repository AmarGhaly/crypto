@if($trade->state == \App\Trade::getPendingState())
    <div class="form-group">
        <p>Please send <span
                class="text-warning">{{$trade->required_payment}} {{strtoupper($trade->base_coin)}}</span>
            to deposit address</p>
        <input type="text" name="" id="" class="form-control" readonly
               value="{{$trade->deposit_address}}">
    </div>
@endif
@if($trade->state == \App\Trade::getWaitingConfirmationState())
    @if($trade->received_balance >= $trade->required_payment)
        <div class="form-group">
            We have detected payment on the deposit address, once its confirmed we will initiate
            the exchange
        </div>
    @else
        <div class="form-group">
            We have detected payment on the deposit address, however its less than {{$trade->required_payment}} {{strtoupper($trade->base_coin)}}.
            In order for trade to confirm, please send additional {{$trade->required_payment-$trade->received_balance}} {{strtoupper($trade->base_coin)}} to deposit address
        </div>
        <div class="form-group">
            <input type="text" name="" id="" class="form-control" readonly
                   value="{{$trade->deposit_address}}">
        </div>
    @endif
@endif
@if($trade->state == \App\Trade::getProcessingState())
    <div class="form-group">
        Payment is complete, we are exchanging the coins now. Once we're done, payment will be sent to the {{strtoupper($trade->other_coin)}} address you provided
    </div>
@endif
@if($trade->state == \App\Trade::getCompletedState())
    <div class="form-group">
        Trade is complete. Coins have been sent to the provided address.
    </div>
    <div class="form-group">
        <label for="">TXID:</label>
        <input type="text" name="" id="" class="form-control" readonly value="{{$trade->morphTrade->txid}}">
    </div>
@endif
@if($trade->state == \App\Trade::getRefundedState())
    <div class="form-group">
        We were unable to make the exchange, coins have been refunded.
    </div>
    <div class="form-group">
        <label for="">TXID:</label>
        <input type="text" name="" id="" class="form-control" readonly value="{{$trade->morphTrade->refund_txid}}">
    </div>
@endif
@if($trade->state == \App\Trade::getCanceledState())
    <div class="form-group">
        There was no payment detected to the provided address. Trade has been canceled.
    </div>

@endif

