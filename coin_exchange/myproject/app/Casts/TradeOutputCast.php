<?php

namespace App\Casts;

use App\Trade\TradeOutput;
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
     * @return TradeOutput
     */
    public function get($model, $key, $value, $attributes)
    {
        return new TradeOutput(
            $attributes['output_order_id'],
            $attributes['output_coin_send'],
            $attributes['output_amount_send'],
            $attributes['output_coin_receive'],
            $attributes['output_amount_receive'],
            $attributes['output_rate'],
            $attributes['output_rate_type'],
            $attributes['output_recipient'],
            $attributes['tx'],
            $attributes['output_status'],
            $attributes['output_updated_at'],
            $attributes['output_updated_at'],
        );
    }

    /**
     * Prepare the given value for storage.
     *
     * @param  \Illuminate\Database\Eloquent\Model  $model
     * @param  string  $key
     * @param  TradeOutput  $value
     * @param  array  $attributes
     * @return array
     */
    public function set($model, $key, $value, $attributes)
    {
        return [
            'output_order_id' => $value->orderId,
            'output_coin_send' => $value->coinSend,
            'output_amount_send' => $value->amountSend,
            'output_coin_receive' => $value->coinReceive,
            'output_amount_receive' => $value->amountReceive,
            'output_rate' => $value->rate,
            'output_rate_type' => $value->rateType,
            'output_recipient' => $value->recipient,
            'tx' => $value->tx,
            'output_status' => $value->status,
            'output_updated_at' => $value->updatedAt,
            'output_created_at' => $value->createdAt,
        ];
    }
}
