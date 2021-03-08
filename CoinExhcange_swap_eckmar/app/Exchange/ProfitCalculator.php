<?php


namespace App\Exchange;


use App\Trade;

class ProfitCalculator
{
    protected static $coins = [
        'btc',
        'xmr'
    ];
    public static function getCurrentProfit() : array
    {
        $profit = [];

        foreach (self::$coins as $coin){
            $profitForCoin = Trade::where('base_coin',$coin)->sum('service_fee');
            $fee = Trade::where('base_coin',$coin)->sum('tx_fee');
            $profit[$coin] = $profitForCoin - $fee;
        }

        return $profit;
    }
}
