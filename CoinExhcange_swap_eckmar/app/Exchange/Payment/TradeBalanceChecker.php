<?php


namespace App\Exchange\Payment;


use App\Exceptions\BalanceCheckingException;
use App\Trade;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class TradeBalanceChecker
{
    /**
     * @var Coin
     */
    protected $payment;

    /**
     * @var Trade
     */
    protected $trade;

    /**
     * @var integer
     */
    protected $minConfirmations;

    public function __construct(Coin $payment,Trade $trade,$minConfirmations)
    {
        $this->payment = $payment;
        $this->trade = $trade;
        $this->minConfirmations = $minConfirmations;
    }

    /**
     * @return float
     */
    public function getBalance(): float
    {
        $address = $this->trade->deposit_address;
        try{
            $balance = $this->payment->getBalance([
                'address' => $address,
                'min_confirmations' => $this->minConfirmations
            ]);
            if (app()->environment() == 'local'){
                Log::info("Balance for trade {$this->trade->id} is {$balance} ({$this->minConfirmations} confirmation check)");
            }
            return $balance;
        } catch (BalanceCheckingException $exception){
            Log::error("Unable to check balance for coin {$exception->getCoin()} {$exception->getMessage()}");
            Log::error($exception);
        } catch (\Exception $exception){
            Log::error($exception);
        }
        return null;
    }
}
