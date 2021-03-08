<?php


namespace App\Trade;


class MorphTradeOutput
{
    public $asset;
    public $address;
    public $seenRate;
    public $finalRate;
    public $networkFee;
    public $convertedAmount;
    public $txid;

    public function __construct(
        $asset,
        $address,
        $seen_rate,
        $final_rate,
        $network_fee,
        $converted_amount,
        $txid
    )
    {
        $this->asset = $asset;
        $this->address = $address;
        $this->seenRate = $seen_rate;
        $this->finalRate = $final_rate;
        $this->networkFee = $network_fee;
        $this->convertedAmount = $converted_amount;
        $this->txid = $txid;
    }
}
