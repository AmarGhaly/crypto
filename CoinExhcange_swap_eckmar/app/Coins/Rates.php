<?php


namespace App\Coins;


use App\Jobs\GetRatesJob;
use App\Trade\Calculator;
use Illuminate\Support\Facades\Cache;

class Rates
{
    protected static $cacheKey = 'rates';
    protected static $cacheTimeMinutes = 30;
    public static function getRates()
    {
        if (!Cache::has(self::$cacheKey)){
            self::setRates();
        }
        $rates = Cache::get(self::$cacheKey);
        return $rates;
    }

    public static function getRatesIncludingFee()
    {
        $rates = self::getRates();
        $newRates = [];
        foreach ($rates as $direction => $value){
            $calculator = new Calculator($value);
            $newRates[$direction] = $calculator->decreaseTotal();
        }
        return $newRates;
    }
    public static function setRates()
    {
        GetRatesJob::dispatch();
    }

    public static function getCacheKey()
    {
        return self::$cacheKey;
    }

    public static function getCacheTime()
    {
        return self::$cacheTimeMinutes*60;
    }

}
