<?php

namespace App\Casts\Morph;

use App\Trade\MorphTradeInput;
use App\Trade\MorphTradeOutput;
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
     * @return MorphTradeInput
     */
    public function get($model, $key, $value, $attributes)
    {
        return new MorphTradeInput(
            $attributes['input_asset'],
            $attributes['input_received'],
            $attributes['input_confirmed_at_height'],
            $attributes['input_deposit_address'],
            $attributes['input_refund_address'],
            $attributes['input_deposit_limits_min'],
            $attributes['input_deposit_limits_max']
        );
    }

    /**
     * Prepare the given value for storage.
     *
     * @param  \Illuminate\Database\Eloquent\Model  $model
     * @param  string  $key
     * @param  MorphTradeInput  $value
     * @param  array  $attributes
     * @return array
     */
    public function set($model, $key, $value, $attributes)
    {
        return [
            'input_asset' => $value->asset,
            'input_received' => $value->received,
            'input_confirmed_at_height' => $value->confirmedAtHeight,
            'input_deposit_address' => $value->depositAddress,
            'input_refund_address' => $value->refundAddress,
            'input_deposit_limits_min' => $value->limits['min'],
            'input_deposit_limits_max' => $value->limits['max'],
        ];
    }
}
