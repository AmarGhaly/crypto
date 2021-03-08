<?php

namespace App\Casts\Morph;

use App\Trade\MorphTradeOutput;
use Illuminate\Contracts\Database\Eloquent\CastsAttributes;

class TradeOutputCast implements CastsAttributes
{
    /**
     * Cast the given value.
     *
     * @param  \Illuminate\Database\Eloquent\Model  $model
     * @param  string  $key
     * @param  mixed  $value
     * @param  array  $attributes
     * @return MorphTradeOutput
     */
    public function get($model, $key, $value, $attributes)
    {
        return new MorphTradeOutput(
            $attributes['output_asset'],
            $attributes['output_address'],
            $attributes['output_seen_rate'],
            $attributes['output_final_rate'],
            $attributes['output_network_fee'],
            $attributes['output_converted_amount'],
            $attributes['txid']
        );
    }

    /**
     * Prepare the given value for storage.
     *
     * @param  \Illuminate\Database\Eloquent\Model  $model
     * @param  string  $key
     * @param  MorphTradeOutput  $value
     * @param  array  $attributes
     * @return array
     */
    public function set($model, $key, $value, $attributes)
    {
        return [
            'output_asset' => $value->asset,
            'output_address' => $value->address,
            'output_seen_rate' => $value->seenRate,
            'output_final_rate' => $value->finalRate,
            'output_network_fee' => $value->networkFee,
            'output_converted_amount' => $value->convertedAmount,
            'txid' => $value->txid,
        ];
    }
}
