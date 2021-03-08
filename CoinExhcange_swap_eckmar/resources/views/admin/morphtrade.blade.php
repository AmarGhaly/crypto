<hr>
<div class="form-group">
    <p>
        Information from MorphToken
    </p>
</div>
<div class="form-group">
    <label for="mid">MID:</label>
    <input type="text" name="mid" id="mid" class="form-control" value="{{$trade->morphTrade->mid}}" readonly>
</div>
<div class="form-group">
    <label for="state">STATE:</label>
    <input type="text" name="state" id="state" class="form-control" value="{{$trade->morphTrade->state}}" readonly>
</div>
<div class="form-group">
    <label for="input_asset">Input asset:</label>
    <input type="text" name="input_asset" id="input_asset" class="form-control" value="{{$trade->morphTrade->input_asset}}" readonly>
</div>
<div class="form-group">
    <label for="input_received">Input received:</label>
    <input type="text" name="input_received" id="input_received" class="form-control" value="{{$trade->morphTrade->input_received}}" readonly>
</div>
<div class="form-group">
    <label for="input_confirmed_at_height">Input confirmed at height:</label>
    <input type="text" name="input_confirmed_at_height" id="input_confirmed_at_height" class="form-control" value="{{$trade->morphTrade->input_confirmed_at_height}}" readonly>
</div>
<div class="form-group">
    <label for="input_deposit_address">Input deposit address:</label>
    <input type="text" name="input_deposit_address" id="input_deposit_address" class="form-control" value="{{$trade->morphTrade->input_deposit_address}}" readonly>
</div>
<div class="form-group">
    <label for="input_refund_address">Input refund address:</label>
    <input type="text" name="input_refund_address" id="input_refund_address" class="form-control" value="{{$trade->morphTrade->input_refund_address}}" readonly>
</div>
<div class="form-group">
    <label for="input_deposit_limits_min">Input deposit limit min:</label>
    <input type="text" name="input_deposit_limits_min" id="input_deposit_limits_min" class="form-control" value="{{$trade->morphTrade->input_deposit_limits_min}}" readonly>
</div>
<div class="form-group">
    <label for="input_deposit_limits_max">Input deposit limit max:</label>
    <input type="text" name="input_deposit_limits_max" id="input_deposit_limits_max" class="form-control" value="{{$trade->morphTrade->input_deposit_limits_max}}" readonly>
</div>
<div class="form-group">
    <label for="output_asset">Output asset:</label>
    <input type="text" name="output_asset" id="output_asset" class="form-control" value="{{$trade->morphTrade->output_asset}}" readonly>
</div>
<div class="form-group">
    <label for="output_address">Output Address:</label>
    <input type="text" name="output_address" id="output_address" class="form-control" value="{{$trade->morphTrade->output_address}}" readonly>
</div>
<div class="form-group">
    <label for="output_seen_rate">Output seen rate:</label>
    <input type="text" name="output_seen_rate" id="output_seen_rate" class="form-control" value="{{$trade->morphTrade->output_seen_rate}}" readonly>
</div>
<div class="form-group">
    <label for="output_final_rate">Output final rate:</label>
    <input type="text" name="output_final_rate" id="output_final_rate" class="form-control" value="{{$trade->morphTrade->output_final_rate}}" readonly>
</div>
<div class="form-group">
    <label for="output_network_fee">Output network fee:</label>
    <input type="text" name="output_network_fee" id="output_network_fee" class="form-control" value="{{$trade->morphTrade->output_network_fee}}" readonly>
</div>
<div class="form-group">
    <label for="output_converted_amount">Output converted amount:</label>
    <input type="text" name="output_converted_amount" id="output_converted_amount" class="form-control" value="{{$trade->morphTrade->output_converted_amount}}" readonly>
</div>
<div class="form-group">
    <label for="txid">TXID:</label>
    <input type="text" name="txid" id="txid" class="form-control" value="{{$trade->morphTrade->txid}}" readonly>
</div>

<div class="form-group">
    <label for="refund_txid">Refund txid:</label>
    <input type="text" name="refund_txid" id="refund_txid" class="form-control" value="{{$trade->morphTrade->refund_txid}}" readonly>
</div>


