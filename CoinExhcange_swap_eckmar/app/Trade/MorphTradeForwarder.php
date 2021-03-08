<?php


namespace App\Trade;



use App\Exceptions\BalanceCheckingException;
use App\Exceptions\WalletSendException;
use App\Exchange\Payment\BitcoinPayment;
use App\Exchange\Payment\PaymentGetter;
use App\Trade;
use Illuminate\Support\Facades\Log;

class MorphTradeForwarder
{

    /**
     * @param Trade $trade
     * @return string|null
     * @throws BalanceCheckingException
     */
    public static function forwardToMorphExchnage(Trade $trade)
    {
        $payment = PaymentGetter::getPayment($trade->base_coin);
        try{
            $address = $trade->morphTrade->input_deposit_address;

            $calculator = new Calculator($trade->received_balance);
            $amount = $calculator->decreaseTotal();
            $fee = $calculator->getFeeAmount();
            $trade->service_fee = $fee;
            if ($payment instanceof BitcoinPayment){
                $trade->sent_amount = $amount;
                $trade->save();
            }
            $tx = $payment->sendToAddress(
                $address,
                $amount
            );
            if (app()->environment() == 'local'){
                Log::info("Trying to forward money for trade {$trade->id} (coin {$trade->base_coin}, address {$address}, amount {$amount})");
                Log::info($tx);
            }
            return $tx;
        } catch (WalletSendException $exception){
            Log::error("Unable to send transaction for coin {$exception->getCoin()} {$exception->getMessage()}");
            Log::error($exception);
            throw new BalanceCheckingException($trade->base_coin,$exception->getMessage());
        } catch (\Exception $exception){
            Log::error($exception);
            throw new BalanceCheckingException($trade->base_coin,$exception->getMessage());
        }
    }
}
