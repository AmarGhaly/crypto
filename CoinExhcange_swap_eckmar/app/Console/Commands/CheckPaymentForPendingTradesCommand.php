<?php

namespace App\Console\Commands;

use App\Jobs\UpdateTradeBalance;
use App\Jobs\UpdateTradeStateToWaitingConfirmations;
use App\Trade;
use Illuminate\Console\Command;

class CheckPaymentForPendingTradesCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'check:pending';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Check if there is payment for pending trades';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {

        $trades = Trade::where('state',Trade::getPendingState())->get();
        foreach ($trades as $trade){
            if (app()->environment() == 'local'){
                $this->info("Attempting state update to waiting_confirmation for trade {$trade->id}");
            }
            UpdateTradeStateToWaitingConfirmations::dispatchNow($trade);
        }
    }
}
