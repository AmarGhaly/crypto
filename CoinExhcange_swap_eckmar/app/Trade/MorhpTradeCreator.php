<?php


namespace App\Trade;


use App\Exceptions\InvalidAddressException;
use App\Exceptions\InvalidMorphRequestException;
use Illuminate\Support\Facades\Http;

class MorhpTradeCreator
{
    public static function getResponse(TradeDetails $details): array
    {
        $api = config('converter.api_address');
        $morhpTradeParameters = new MorhpTradeParameters($details);
        $params = $morhpTradeParameters->getTradeCreateParams();

        $response = Http::post($api . '/morph', $params);
        if ($response->ok()) {
            $data = $response->json();
            return $data;
        } else {
            $responseData = $response->json();
            if ($responseData['code'] == 1012){
                throw new InvalidAddressException(strtoupper($details->baseCoin). ' address is not valid');
            }
            if ($responseData['code'] == 1026){
                throw new InvalidAddressException(strtoupper($details->otherCoin). ' address is not valid');
            }
            throw new InvalidMorphRequestException($responseData,'Invalid response from API');
        }
    }
}
