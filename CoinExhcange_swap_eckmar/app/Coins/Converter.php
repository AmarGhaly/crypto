<?php

namespace App\Coins;
use  App\Http\Controllers\Cryptiswap;
require_once '/Users/amarghaly/Downloads/CoinExhcange_swap_eckmar/app/Http/Controllers/Cryptiswap.php';

class Converter
{
    const XMR_TO_PICONERO = 1000000000000;
   
    public static function xmrToBtc($xmr, $actualRate = true): float
    {
        $cryptiswap = new Cryptiswap();
        $rate = floatval($cryptiswap->getRate('XMR', 'BTC', 'dynamic'));
        return $rate;
    }

    public static function btcToXmr($btc, $actualRate = true): float
    {
        $cryptiswap = new Cryptiswap();
        $rate = floatval($cryptiswap->getRate('BTC', 'XMR', 'dynamic'));
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
