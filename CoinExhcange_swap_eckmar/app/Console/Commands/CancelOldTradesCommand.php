<?php

namespace App\Console\Commands;

use App\Jobs\CancelOldTrade;
use App\Jobs\CancelOldTradeWithBalance;
use App\Trade;
use Carbon\Carbon;
use Illuminate\Console\Command;

class CancelOldTradesCommand extends Command
{
    /**
     * After how many hours to delete the trade in pending state
     * @var int
     */
    protected $deleteOlderThan = 24;

    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'check:old';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Cancel all trades older than 24 hours that haven\'t received payments, or older than 96 hours that have payment';

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
        $trades = Trade::where('created_at', '<=', Carbon::now()->subHours(24)->toDateTimeString())->whereNotIn('state',[
            Trade::getCanceledState(),
            Trade::getCompletedState(),
            Trade::getRefundedState()
        ])->get();
        foreach ($trades as $trade){
            if (app()->environment() == 'local'){
                $this->info("Attempting state update to canceled for trade {$trade->id}");
            }
            CancelOldTrade::dispatchNow($trade,$this->deleteOlderThan);
        }
        // Old trades with balance
        $trades = Trade::where('created_at', '<=', Carbon::now()->subHours(96)->toDateTimeString())->where('received_balance','>','0')->whereNotIn('state',[
            Trade::getCanceledState(),
            Trade::getCompletedState(),
            Trade::getRefundedState()
        ])->get();
        foreach ($trades as $trade){
            if (app()->environment() == 'local'){
                $this->info("Attempting state update to canceled for trade {$trade->id}");
            }

            CancelOldTradeWithBalance::dispatchNow($trade,$this->deleteOlderThan);
        }
    }
}
