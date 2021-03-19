<?php

namespace App\Jobs;

use App\Coins\Rates;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Cache;

class GetRatesJob implements ShouldQueue
{
    // use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;


    // protected $api;
    // /**
    //  * Create a new job instance.
    //  *
    //  * @return void
    //  */
    // public function __construct()
    // {
    //     $this->api = config('converter.api_address');
    // }

    // /**
    //  * Execute the job.
    //  *
    //  * @return void
    //  */
    // public function handle()
    // {

        // $response = Http::get($this->api.'/rates');
        // if ($response->ok()){
        //     $data = $response->json()['data'];
        //     $rates = [];
        //     $rates["BTCXMR"] = $data['BTC']['XMR'];
        //     $rates["XMRBTC"] = $data['XMR']['BTC'];
        //     Cache::put(Rates::getCacheKey(),$rates,Rates::getCacheTime());
        // } else {
        //     throw new \Exception('Invalid response from API');
        // }

   // }
}
