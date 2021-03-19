<?php


namespace App\Trade;


class TradeParameters
{
    /**
     * @var TradeDetails
     */
    protected $tradeDetails;

    public function __construct(TradeDetails $tradeDetails)
    {
        $this->tradeDetails = $tradeDetails;
    }

    public function getTradeCreateParams(): array
    {
        $inputArray = [
            'coin_send' => strtoupper($this->tradeDetails->coinSend),
        ];
        $outputArray = [
            'coin_receive' => strtoupper($this->tradeDetails->coinReceive),
            'recipient' => $this->tradeDetails->recipient
        ];

        return [
            'input' => $inputArray,
            'output' => [$outputArray]
        ];
    }
}
