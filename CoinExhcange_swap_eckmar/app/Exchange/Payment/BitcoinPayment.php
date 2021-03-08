<?php

namespace App\Exchange\Payment;


use App\Exceptions\AddressGenerationException;
use App\Exceptions\BalanceCheckingException;
use App\Exchange\Utility\RPCWrapper;
use App\Exchange\Utility\BitcoinConverter;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Log;

class BitcoinPayment implements Coin
{

    /**
     * @var int
     */
    public $optimalMinimumConfirmations = 1;

    /**
     * RPCWrapper Server instance
     *
     * @var
     */
    protected $bitcoind;

    /**
     * RPCWrapper constructor.
     */
    public function __construct()
    {
        $this->bitcoind = new RPCWrapper(config('coins.bitcoin.username'),
            config('coins.bitcoin.password'),
            config('coins.bitcoin.host'),
            config('coins.bitcoin.port'));
    }

    /**
     * Generate new address with optional btc user parameter
     *
     * @param array $params
     * @return string
     * @throws \Exception
     */
    function generateAddress(array $params = []): string
    {
        // only if the btc user is set then call with parameter
        if (array_key_exists('btc_user', $params))
            $address = $this->bitcoind->getnewaddress($params['btc_user']);
        else
            $address = $this->bitcoind->getnewaddress();

        // Error in bitcoin
        if ($this->bitcoind->error) {
            throw new AddressGenerationException('btc', $this->bitcoind->error);
        }


        return $address;
    }


    /**
     * Returns the total received balance of the account
     *
     * @param array $params
     * @return float
     * @throws BalanceCheckingException
     */
    function getBalance(array $params = []): float
    {
        // first check by address
        if (!array_key_exists('address', $params))
        {
            throw new \Exception('You havent specified any parameter');

        }
        $minConfirmations = $this->optimalMinimumConfirmations;
        if (array_key_exists('min_confirmations', $params))
        {
            $minConfirmations = $params['min_confirmations'];
        }
        $balance = $this->bitcoind->getreceivedbyaddress($params['address'], $minConfirmations);

        if ($this->bitcoind->error)
            throw new BalanceCheckingException('btc',$this->bitcoind->error);

        return $balance;
    }

    /**
     * Calls a procedure to send from address to address some amount
     *
     * @param string $fromAddress
     * @param string $toAddress
     * @param float $amount
     * @throws \Exception
     */
    function sendToAddress(string $toAddress, float $amount)
    {
        $parsedAmount = round($amount,7,PHP_ROUND_HALF_DOWN);
        // call bitcoind procedure
        $txid = $this->bitcoind->sendtoaddress($toAddress, $parsedAmount,"forwardedTx","",true,true,2);

        if ($this->bitcoind->error)
            throw new \Exception("Sending to $toAddress amount $amount \n" . $this->bitcoind->error);
        return $txid;
    }

    /**
     * Send to array of addresses
     *
     * @param string $fromAccount
     * @param array $addressesAmounts
     * @throws \Exception
     */
    function sendToMany(array $addressesAmounts)
    {
        // send to many addresses
//        foreach ($addressesAmounts as $address => $amount){
//            $this -> bitcoind -> sendtoaddress($address, $amount);
//        }

        $txid = $this->bitcoind->sendmany("", $addressesAmounts, (int)config('marketplace.bitcoin.minconfirmations'));


        if ($this->bitcoind->error) {
            $errorString = "";
            foreach ($addressesAmounts as $address => $amount) {
                $errorString .= "To $address : $amount \n";
            }
            throw new \Exception($this->bitcoind->error . "\nSending to: $errorString");
        }
        return $txid;
    }

    /**
     * Convert USD to equivalent BTC amount, rounded on 8 decimals
     *
     * @param $usd
     * @return float
     */
    function usdToCoin($usd): float
    {
        return round(BitcoinConverter::usdToBtc($usd), 8, PHP_ROUND_HALF_DOWN);
    }


    /**
     * Returns the string label of the coin
     *
     * @return string
     */
    function coinLabel(): string
    {
        return 'btc';
    }


}
