<?php


namespace App\Trade;


use App\Coins\Converter;
use App\Jobs\GetLimitsJob;
use Illuminate\Support\Facades\Cache;

class Limits
{
    protected static $cacheKey = 'limits';
    protected static $cacheTimeMinutes = 30;

    public static function getActualLimits()
    {
        if (!Cache::has(self::$cacheKey)) {
            self::setLimits();
        }
        $limits = Cache::get(self::$cacheKey);
        return $limits;
    }

    public static function getLimits()
    {
        if (!Cache::has(self::$cacheKey)) {
            self::setLimits();
        }
        $limits = Cache::get(self::$cacheKey);
        foreach ($limits as $direction => $directionLimits){
            $currentLimit = $directionLimits['min'];
            $limitMultiplier = floatval(config('converter.limit_multiplier')[$direction]);
            $limits[$direction]['min'] = $currentLimit * $limitMultiplier;
        }
        return $limits;
    }


    public static function setLimits()
    {
        GetLimitsJob::dispatch();
    }

    public static function getCacheKey()
    {
        return self::$cacheKey;
    }

    public static function getCacheTime()
    {
        return self::$cacheTimeMinutes * 60;
    }

    public static function isWithinLimits(TradeDetails $tradeDetails): bool
    {
        $limits = self::getLimits();
        $inputLimit = $limits[$tradeDetails->direction];
        if ($tradeDetails->baseCoin == 'btc'){
            $satoshi = Converter::btcToSatoshi(floatval($tradeDetails->requiredPayment));

            if ($satoshi > $inputLimit['min'] && $satoshi < $inputLimit['max']){
                return true;
            }
        }
        if ($tradeDetails->baseCoin == 'xmr'){
            $piconero = Converter::toPicoNero($tradeDetails->requiredPayment);
            if ($piconero > $inputLimit['min'] && $piconero < $inputLimit['max']){
                return true;
            }
        }
        return false;
    }
}
