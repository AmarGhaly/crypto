<?php

namespace App;

use App\Trade\TradeDetails;
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
    use Uuid;
    protected $keyType = 'string';
    public $incrementing = false;
    protected $guarded = [];

    public function tradeModel()
    {
        return $this->hasOne(TradeModel::class);
    }


    public function setTradeDetailParameters(TradeDetails $details)
    {
        $this->direction = $details->direction;
        $this->amount_send = $details->amount_send;
        $this->coin_send = $details->coinSend;
        $this->coin_receive = $details->coinReceive;
        $this->rate = $details->rate;
        // $this->actual_rate = $details->actualRate;
        $this->recipient = $details->recipient;
    }
}
