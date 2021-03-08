<?php

namespace App\Console\Commands;

use App\Jobs\UpdateTradeStatusJob;
use App\Trade;
use Illuminate\Console\Command;

class UpdateSentTransactionsCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'check:sent';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Check trades that are sent to the morphtoken exchange for new status';

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

        $trades = Trade::where('state',Trade::getProcessingState())->where('sent_amount','>',0)->with('morphTrade')->get();
        foreach($trades as $trade){
            if (app()->environment() == 'local'){
                $this->info("Attempting to update status for trade with id {$trade->id}");
            }
            UpdateTradeStatusJob::dispatch($trade);
        }
    }
}
