<?php

namespace App;

use App\Casts\Morph\TradeInputCast;
use App\Casts\Morph\TradeOutputCast;
use App\Exceptions\InvalidMorphRequestException;
use App\Trade\MorhpTradeCreator;
use App\Trade\MorhpTradeParameters;
use App\Trade\MorphTradeInput;
use App\Trade\MorphTradeOutput;
use App\Trade\TradeDetails;
use GoldSpecDigital\LaravelEloquentUUID\Database\Eloquent\Uuid;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class MorphTrade extends Model
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
        return $this->belongsTo(Trade::class,'morph_trade_id');
    }

    public static function createFromDetails(TradeDetails $details, Trade $trade): MorphTrade
    {
        $params = MorhpTradeCreator::getResponse($details);

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
        $this->state = $params['state'];

        $tradeInput = new MorphTradeInput(
            $input['asset'],
            $input['received'],
            $input['confirmed_at_height'],
            $input['deposit_address'],
            $input['refund_address'],
            $input['limits']['min'],
            $input['limits']['max']

        );
        $this->input = $tradeInput;

        $tradeOutput = new MorphTradeOutput(
            $output['asset'],
            $output['address'],
            $output['seen_rate'],
            $output['final_rate'],
            $output['network_fee']['fee'],
            $output['converted_amount'],
            $output['txid']
        );

        $this->output = $tradeOutput;
        $refund = $params['refund'];
        if ($refund !== null){
            if ($refund['txid'] !== null){
                $this->refund_txid = $refund['txid'];
            }
        }
    }
}
