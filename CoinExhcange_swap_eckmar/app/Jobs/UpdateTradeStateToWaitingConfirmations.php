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

class UpdateTradeStateToWaitingConfirmations implements ShouldQueue
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
    public function __construct(Trade $trade)
    {
        $this->trade = $trade;
        $this->payment = PaymentGetter::getPayment($trade->base_coin);
        $this->minConfirmations = 0;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $balanceChecker = new TradeBalanceChecker($this->payment,$this->trade,$this->minConfirmations);
        $balance = $balanceChecker->getBalance();
        if ($balance !== null && $balance > 0){
            $this->trade->state = 'waiting_confirmation';
            $this->trade->save();
        }
    }
}
