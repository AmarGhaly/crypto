<?php


namespace App\Trade;


class MorphTradeInput
{
    public $asset;
    public $confirmedAtHeight;
    public $depositAddress;
    public $received;
    public $refundAddress;
    public $limits;

    public function __construct(
        $asset,
        $received,
        $confirmed_at_height,
        $deposit_address,
        $refund_address,
        $limits_min,
        $limits_max

    )
    {
        $this->asset = $asset;
        $this->confirmedAtHeight = $confirmed_at_height;
        $this->depositAddress = $deposit_address;
        $this->received = $received;
        $this->refundAddress = $refund_address;
        $this->limits = [
                'min' => $limits_min,
                'max' => $limits_max
            ];

    }
}
