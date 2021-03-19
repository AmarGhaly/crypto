<?php


namespace App\Trade;


use App\Coins\Rates;

class TradeDetails
{
    public $amountSend;
    public $direction;
    public $coinSend;
    public $coinReceive;
    public $rate;
    public $amountReceive;
    public $recipient;

    public function __construct(array $params)
    {
        $this->amountSend = $params['amount_send'];
        $this->direction = $params['direction'];
        $this->coinSend = TradeDirection::getBaseCoin($this->direction);
        $this->coinReceive = TradeDirection::getOtherCoin($this->direction);
        $rate = Rates::getRates($coin_send, $coin_receive, $rate)[strtoupper($this->direction)];
        // $calculator = new Calculator($rate);
        // $this->actualRate = $rate;
        // $this->rate = $calculator->decreaseTotal();
        $this->amountReceive= $this->rate*$this->amountSend;
    }

    // public function putIntoSession()
    // {
    //     if (session()->has(self::$sessionKey)){
    //         session()->forget(self::$sessionKey);
    //     }
    //     session()->put(self::$sessionKey,$this);
    // }

    // public static function getFromSession(): ?TradeDetails
    // {
    //     if (!session()->has(self::$sessionKey)){
    //         return null;
    //     }
    //     return session()->get(self::$sessionKey);
    // }

}
