<?php

namespace App\Jobs;

use App\Trade;
use Carbon\Carbon;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class CancelOldTradeWithBalance implements ShouldQueue
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

        if ($this->trade->state == Trade::getWaitingConfirmationState() && $this->trade->received_balance < $this->trade->required_payment){
            $this->trade->state = Trade::getCanceledState();
            $this->trade->save();
        }
    }
}
