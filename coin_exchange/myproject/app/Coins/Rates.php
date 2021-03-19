<?php


namespace App\Coins;


use App\Jobs\GetRatesJob;
// use App\Trade\Calculator;
use App\Http\Controllers\SwapController;
use Illuminate\Support\Facades\Cache;

class Rates
{
    public static function getRates($coin_send, $coin_receive, $rate_type)
    {
        $swapcontroller = new SwapController();
        $rate = floatval($swapcontroller->getRate($coin_send, $coin_receive, $rate_type));
        return $rate;
    }

}
