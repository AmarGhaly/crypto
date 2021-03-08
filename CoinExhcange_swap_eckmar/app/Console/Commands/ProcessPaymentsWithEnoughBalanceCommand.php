<?php

namespace App\Console\Commands;

use App\Jobs\ProcessTradeJob;
use App\Trade;
use Illuminate\Console\Command;

class ProcessPaymentsWithEnoughBalanceCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'check:processing';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Check payments in processing state and send to MorphToken address';

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
        $trades = Trade::where('state',Trade::getProcessingState())->where('sent_amount',0)->get();
        foreach($trades as $trade){
            if (app()->environment() == 'local'){
                $this->info("Attempting payment forwarding for trade with id {$trade->id}");
            }
            ProcessTradeJob::dispatch($trade);
        }


    }
}
