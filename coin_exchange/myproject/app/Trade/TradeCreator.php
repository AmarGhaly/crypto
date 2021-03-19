<?php


namespace App\Trade;


use App\Exceptions\InvalidAddressException;
use App\Exceptions\InvalidRequestException;
use Illuminate\Support\Facades\Http;

class TradeCreator
{
    public static function getResponse(TradeDetails $details): array
    {
        $api = config('converter.api_address');
        $tradeParameters = new TradeParameters($details);
        $params = $tradeParameters->getTradeCreateParams();

        $response = Http::post($api . '/morph', $params);
        if ($response->ok()) {
            $data = $response->json();
            return $data;
        } else {
            $responseData = $response->json();
            if ($responseData['code'] == 1012){
                throw new InvalidAddressException(strtoupper($details->coinSend). ' address is not valid');
            }
            if ($responseData['code'] == 1026){
                throw new InvalidAddressException(strtoupper($details->coinReceive). ' address is not valid');
            }
            throw new InvalidRequestException($responseData,'Invalid response from API');
        }
    }
}
