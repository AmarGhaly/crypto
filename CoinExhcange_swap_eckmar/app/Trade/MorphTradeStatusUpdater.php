<?php


namespace App\Trade;


use App\Exceptions\InvalidAddressException;
use App\Exceptions\InvalidMorphRequestException;
use App\Trade;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class MorphTradeStatusUpdater
{
    public static function getResponse(Trade $trade)
    {
        $api = config('converter.api_address');


        $response = Http::get($api . '/morph/'.$trade->morphTrade->mid);
        if ($response->ok()) {
            $data = $response->json();
            return $data;
        } else {
            $responseData = $response->json();
            Log::error($responseData);
            throw new InvalidMorphRequestException($responseData,'Invalid response from API');
        }
    }
}
