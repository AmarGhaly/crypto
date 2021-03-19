<?php


namespace App\Trade;


class TradeOutput
{
    public $orderId;
    public $coinSend;
    public $amountSend;
    public $coinReceive;
    public $amountReceive;
    public $rate;
    public $rateType;
    public $recipient;
    public $tx;
    public $status;
    public $updatedAt;
    public $createdAt;

    public function __construct(
         $orderId,
         $coinSend,
         $amountSend,
         $coinReceive,
         $amountReceive,
         $rate,
         $rateType,
         $recipient,
         $tx,
         $status,
         $updatedAt,
         $createdAt
    )

    {
        $this->orderId = $order_id;
        $this->coinSend = $coin_send;
        $this->amountSend= $amount_send;
        $this->coinReceive = $coin_receive;
        $this->amountReceive= $amount_receive;
        $this->rate = $rate;
        $this->rate_type = $rate_type;
        $this->recipient = $recipient;
        $this->tx = $tx;
        $this->status = $status;
        $this->updatedAt = $updated_at;
        $this->createdAt = $created_at;
    }
}
