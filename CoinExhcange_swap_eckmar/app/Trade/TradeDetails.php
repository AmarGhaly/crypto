<?php


namespace App\Trade;


use App\Coins\Rates;

class TradeDetails
{
    public $requiredPayment;
    public $direction;
    public $baseCoin;
    public $otherCoin;
    public $rate;
    public $actualRate;
    public $expectedReturn;
    public $receivingAddress;
    public $refundAddress;
    protected static $sessionKey = 'trade_details';
    public function __construct(array $params)
    {
        $this->requiredPayment = $params['required_payment'];
        $this->direction = $params['direction'];
        $this->baseCoin = TradeDirection::getBaseCoin($this->direction);
        $this->otherCoin = TradeDirection::getOtherCoin($this->direction);
        $rate = Rates::getRates()[strtoupper($this->direction)];
        $calculator = new Calculator($rate);
        $this->actualRate = $rate;
        $this->rate = $calculator->decreaseTotal();
        $this->expectedReturn = $this->rate*$this->requiredPayment;
    }

    public function putIntoSession()
    {
        if (session()->has(self::$sessionKey)){
            session()->forget(self::$sessionKey);
        }
        session()->put(self::$sessionKey,$this);
    }

    public static function getFromSession(): ?TradeDetails
    {
        if (!session()->has(self::$sessionKey)){
            return null;
        }
        return session()->get(self::$sessionKey);
    }

}
