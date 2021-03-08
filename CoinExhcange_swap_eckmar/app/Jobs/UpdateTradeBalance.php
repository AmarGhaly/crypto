<?php

namespace App\Jobs;

use App\Exceptions\BalanceCheckingException;
use App\Exchange\Payment\BitcoinPayment;
use App\Exchange\Payment\Coin;
use App\Exchange\Payment\PaymentGetter;
use App\Exchange\Payment\TradeBalanceChecker;
use App\Trade;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class UpdateTradeBalance implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * @var Trade
     */
    protected $trade;
    /**
     * @var Coin
     */
    protected $payment;

    /**
     * @var integer
     */
    protected $minConfirmations;

    /**
     * UpdateTradeBalance constructor.
     * @param Trade $trade
     * @param null $minConfirmations
     */
    public function __construct(Trade $trade, $minConfirmations = null)
    {
        $this->trade = $trade;
        $this->payment = PaymentGetter::getPayment($trade->base_coin);
        if ($minConfirmations == null) {
            if ($this->payment instanceof BitcoinPayment) {
                $this->minConfirmations = $this->payment->optimalMinimumConfirmations;
            }
        } else {
            $this->minConfirmations = $minConfirmations;
        }
    }

    /**
     * @return void
     */
    public function handle()
    {
        $balanceChecker = new TradeBalanceChecker($this->payment, $this->trade, $this->minConfirmations);
        $balance = $balanceChecker->getBalance();
        if ($balance !== null && $balance > 0) {
            $this->trade->received_balance = $balance;

            if ($this->trade->received_balance >= $this->trade->required_payment) {
                $this->trade->state = Trade::getProcessingState();
            }

            $this->trade->save();
        }

    }
}
