<?php

namespace App\Casts;

use App\Trade\TradeInput;
use Illuminate\Contracts\Database\Eloquent\CastsAttributes;

class TradeInputCast implements CastsAttributes
{
    /**
     * Cast the given value.
     *
     * @param  \Illuminate\Database\Eloquent\Model  $model
     * @param  string  $key
     * @param  mixed  $value
     * @param  array  $attributes
     * @return TradeInput
     */
    public function get($model, $key, $value, $attributes)
    {
        return new TradeInput(
            $attributes['input_coin_send'],
            $attributes['input_coin_receive'],
            $attributes['input_rate_type'],
            $attributes['input_amount_send'],
            $attributes['input_recipient'],
            // $attributes['input_deposit_limits_min'],
            // $attributes['input_deposit_limits_max']
        );
    }

    /**
     * Prepare the given value for storage.
     *
     * @param  \Illuminate\Database\Eloquent\Model  $model
     * @param  string  $key
     * @param  TradeInput  $value
     * @param  array  $attributes
     * @return array
     */
    public function set($model, $key, $value, $attributes)
    {
        return [
            'input_coin_send' => $value->coinSend,
            'input_coin_receive' => $value->coinReceive,
            'input_rate_type' => $value->rateType,
            'input_amount_send' => $value->amountSend,
            'input_recipient' => $value->recipient,
            // 'input_deposit_limits_min' => $value->limits['min'],
            // 'input_deposit_limits_max' => $value->limits['max'],
        ];
    }
}
