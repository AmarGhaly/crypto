<?php

namespace App;

use App\Casts\TradeInputCast;
use App\Casts\TradeOutputCast;
use App\Exceptions\InvalidRequestException;
use App\Trade\TradeCreator;
use App\Trade\TradeParameters;
use App\Trade\TradeInput;
use App\Trade\TradeOutput;
use App\Trade\TradeDetails;
use GoldSpecDigital\LaravelEloquentUUID\Database\Eloquent\Uuid;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class TradeModel extends Model
{
    use Uuid;

    /**
     * The attributes that should be cast.
     *
     * @var array
     */
    protected $casts = [
        'input' => TradeInputCast::class,
        'output' => TradeOutputCast::class,
    ];

    protected $keyType = 'string';
    public $incrementing = false;
    protected $guarded = [];

    public function trade()
    {
        return $this->belongsTo(Trade::class,'trade_id');
    }

    public static function createFromDetails(TradeDetails $details, Trade $trade): Trade
    {
        $params = TradeCreator::getResponse($details);

        $mt = new self();
        $mt->setPropertiesFromResponse($params);
        $mt->trade_id = $trade->id;
        $mt->save();
        return $mt;
    }

    public function setPropertiesFromResponse($params)
    {
        $input = $params['input'];
        $output = $params['output'][0];
        $this->mid = $params['id'];
        // $this->state = $params['state'];

        $tradeInput = new TradeInput(
            $input['coin_send'],
            $input['coin_receive'],
            $input['rate_type'],
            $input['amount_send'],
            $input['recipient'],
            // $input['limits']['min'],
            // $input['limits']['max']

        );
        $this->input = $tradeInput;

        $tradeOutput = new TradeOutput(
            $output['order_id'],
            $output['coin_send'],
            $output['amount_send'],
            $output['coin_receive'],
            $output['amount_send'],
            $output['rate'],
            $output['rate_type'],
            $output['recipient'],
            $output['tx'],
            $output['status'],
            $output['updated_at'],
            $output['created_at']
        );

        $this->output = $tradeOutput;
        // $refund = $params['refund'];
        // if ($refund !== null){
        //     if ($refund['txid'] !== null){
        //         $this->refund_txid = $refund['txid'];
        //     }
        // }
    }
}
