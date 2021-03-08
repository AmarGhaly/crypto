<?php

namespace App;

use App\Trade\TradeDetails;
use App\Traits\TradeStates;
use GoldSpecDigital\LaravelEloquentUUID\Database\Eloquent\Uuid;
use Illuminate\Database\Eloquent\Model;


/**
 * @property string direction
 * @property string base_coin
 * @property string other_coin
 * @property float required_payment
 * @property float rate
 * @property float actual_rate
 * @property float expected_return
 * @property float received_balance
 * @property float sent_amount
 * @property float service_fee
 * @property string refund_address
 * @property string state
 * @property string deposit_address
 * @property string forward_txid
 */
class Trade extends Model
{
    use Uuid, TradeStates;
    protected $keyType = 'string';
    public $incrementing = false;
    protected $guarded = [];

    public function morphTrade()
    {
        return $this->hasOne(MorphTrade::class);
    }


    public function setTradeDetailParameters(TradeDetails $details)
    {
        $this->direction = $details->direction;
        $this->required_payment = $details->requiredPayment;
        $this->base_coin = $details->baseCoin;
        $this->other_coin = $details->otherCoin;
        $this->rate = $details->rate;
        $this->actual_rate = $details->actualRate;
        $this->expected_return = $details->expectedReturn;
        $this->refund_address = $details->refundAddress;
        $this->state = 'waiting_payment';
    }
}
