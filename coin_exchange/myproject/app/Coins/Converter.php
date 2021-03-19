<?php

namespace App\Coins;
use  App\Http\Controllers\TradeController;

class Converter
{
    const XMR_TO_PICONERO = 1000000000000;
   
    public static function xmrToBtc($xmr): float
    {
        $rate = floatval(Rates::getRates('XMR','BTC','dynamic'));
        return $xmr * $rate;
    }

    public static function btcToXmr($btc): float
    {
        $rate = floatval(Rates::getRates('BTC','XMR','dynamic'));
        return $btc * $rate;
    }


    public static function toXmr($piconero)
    {
        return $piconero / self::XMR_TO_PICONERO;
    }


    public static function satoshiToBtc(int $satoshi): float
    {
        return $satoshi / 100000000;
    }
    public static function btcToSatoshi(float $btc): int
    {
        return $btc * 100000000;
    }
}
