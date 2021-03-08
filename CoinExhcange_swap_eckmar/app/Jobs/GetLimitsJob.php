<?php

namespace App\Jobs;


use App\Trade\Limits;
use App\Trade\TradeDirection;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Http;

class GetLimitsJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $api;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->api = config('converter.api_address');
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $limits = [];
        foreach (TradeDirection::getValidDirections() as $tradeDirection){
            $limits[$tradeDirection] = [];
        }

        foreach (TradeDirection::getValidDirections() as $tradeDirection){
            $input = [
                'asset' => strtoupper(TradeDirection::getBaseCoin($tradeDirection))
            ];
            $output = [
                'asset' => strtoupper(TradeDirection::getOtherCoin($tradeDirection)),
                'weight' => 10000
            ];
            $response = Http::post($this->api . '/limits', [
                'input' => $input,
                'output' => [$output]
            ]);
            if ($response->ok()) {

                $data = $response->json();
                $dataLimits = $data['input']['limits'];
                $limits[$tradeDirection] = $dataLimits;
            } else {
                throw new \Exception('Invalid response from API');
            }
        }
        Cache::put(Limits::getCacheKey(), $limits, Limits::getCacheTime());
    }
}
