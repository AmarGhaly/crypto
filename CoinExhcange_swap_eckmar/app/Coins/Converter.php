<?php

namespace App\Coins;
use  App\Http\Controllers\TradeSwap;

class Converter
{
    const XMR_TO_PICONERO = 1000000000000;
   
    public static function xmrToBtc($xmr, $actualRate = true): float
    {
        $tradeswap = new TradeSwap();
        $rate = floatval($tradeswap->getRate('XMR', 'BTC', 'dynamic'));
        return $rate;
    }

    public static function btcToXmr($btc, $actualRate = true): float
    {
        $tradeswap = new TradeSwap();
        $rate = floatval($tradeswap->getRate('BTC', 'XMR', 'dynamic'));
        return $rate;
    }

    public static function toPicoNero($xmr)
    {
        return $xmr * self::XMR_TO_PICONERO;
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
