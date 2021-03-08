<?php

namespace App\Jobs;

use App\Coins\Converter;
use App\Exceptions\WalletSendException;
use App\Trade;
use App\Trade\MorphTradeForwarder;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class ProcessTradeJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * @var Trade
     */
    protected $trade;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct(Trade $trade)
    {
        $this->trade = $trade;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        try{
            DB::beginTransaction();
            $tx = MorphTradeForwarder::forwardToMorphExchnage($this->trade);
            if ($this->trade->base_coin == 'xmr'){
                $this->trade->forward_txid = $tx['tx_hash'];
                $this->trade->sent_amount = Converter::toXmr($tx['amount']);
                $this->trade->tx_fee = Converter::toXmr($tx['fee']);
            }
            if ($this->trade->base_coin == 'btc'){

                $this->trade->forward_txid = $tx;
            }
            $this->trade->save();
            DB::commit();
        } catch( \Exception $exception){
            Log::error($exception);
            DB::rollBack();
        }
    }
}
