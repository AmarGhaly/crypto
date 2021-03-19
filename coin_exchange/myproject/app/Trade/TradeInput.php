<?php


namespace App\Trade;


class TradeInput
{
    public $coinSend;
    public $coinReceive;
    public $rateType;
    public $amountSend;
    public $recipient;
    // public $limits;

    public function __construct(
        $coinSend,
        $coinReceive,
        $rateType,
        $amountSend,
        $recipient
        // $limits_min,
        // $limits_max
    )

    {
        $this->coinSend = $coin_send;
        $this->coinReceive = $coin_receive;
        $this->rateType = $rate_type;
        $this->amountSend = $amount_send;
        $this->recipient = $recipient;
        // $this->limits = [
        //         'min' => $limits_min,
        //         'max' => $limits_max
        //     ];

    }
}
