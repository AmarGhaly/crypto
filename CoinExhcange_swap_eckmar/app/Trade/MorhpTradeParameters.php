<?php


namespace App\Trade;


class MorhpTradeParameters
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
            'asset' => strtoupper($this->tradeDetails->baseCoin),
            'refund' => $this->tradeDetails->refundAddress,
        ];
        $outputArray = [
            'asset' => strtoupper($this->tradeDetails->otherCoin),
            'weight' => 10000,
            'address' => $this->tradeDetails->receivingAddress
        ];

        return [
            'input' => $inputArray,
            'output' => [$outputArray]
        ];
    }
}
