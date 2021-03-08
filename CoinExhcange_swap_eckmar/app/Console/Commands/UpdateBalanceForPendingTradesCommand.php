<?php

namespace App\Console\Commands;

use App\Jobs\UpdateTradeBalance;
use App\Jobs\UpdateTradeStateToWaitingConfirmations;
use App\Trade;
use Illuminate\Console\Command;

class UpdateBalanceForPendingTradesCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'check:waiting';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Check if there is payment with enough confirmations for pending trades';

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
        $trades = Trade::where('state',Trade::getWaitingConfirmationState())->get();
        foreach ($trades as $trade){
            if (app()->environment() == 'local'){
                $this->info("Attempting balance update for trade {$trade->id}");
            }
            UpdateTradeBalance::dispatchNow($trade);
        }
    }
}
