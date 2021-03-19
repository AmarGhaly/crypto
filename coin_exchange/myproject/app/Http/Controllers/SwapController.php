<?php
namespace App\Http\Controllers;
 
class SwapController
{
  
    public function __construct()
    {
        $this->apikey = 'M<nDp{^QVa{tD`+94a\Cj-gRyP-<3Pedt4fR=$qa';  
        $this->serverurl = "https://admin.cryptiswap.org"; 
    }
    public static function getRate($coin_send, $coin_receive, $type)
    {
        $post = [
            'apikey' => 'M<nDp{^QVa{tD`+94a\Cj-gRyP-<3Pedt4fR=$qa',
            'coin_send' => $coin_send,
            'coin_receive' => $coin_receive,
            'type' => $type,
        ];

        $ch = curl_init();

        curl_setopt($ch, CURLOPT_URL, "https://admin.cryptiswap.org/api/api_get_rate");
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $post);

        $server_response = curl_exec($ch);

        curl_close($ch);

        $result = json_decode($server_response , JSON_PRETTY_PRINT);
        return $result['data'];
        //return view('cryptiswap', ['result'=>$result]);
    }

    public function makeOrder($coin_send, $coin_receive, $rate_type, $amount_send, $recipient)
    {
        $rate = $this->getRate($coin_send, $coin_receive, $rate_type);

        $post = [
            'apikey' => 'M<nDp{^QVa{tD`+94a\Cj-gRyP-<3Pedt4fR=$qa',
            'coin_send' => $coin_send,
            'amount_send' => $amount_send,
            'coin_receive' => $coin_receive,
            'amount_receive' => 100,
            'rate' => $rate,
            'rate_type' => $rate_type,
            'recipient' => $recipient,
        ];

        $ch = curl_init();

        curl_setopt($ch, CURLOPT_URL, "https://admin.cryptiswap.org/api/api_make_order");
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $post);

        $server_response = curl_exec($ch);

        curl_close($ch);

        $result = json_decode($server_response, JSON_PRETTY_PRINT);
       // return $result;
    return view('cryptiswap', ['result'=>$result]);
    }

    public function checkOrder($order_id)
    {


        $post = [
            'apikey' =>'M<nDp{^QVa{tD`+94a\Cj-gRyP-<3Pedt4fR=$qa',
            'order_id' => $order_id,
        ];

        $ch = curl_init();

        curl_setopt($ch, CURLOPT_URL, "https://admin.cryptiswap.org/api/api_check_order");
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $post);

        $server_response = curl_exec($ch);

        curl_close($ch);

        $result = json_decode($server_response);
        return $result;
    }
}
