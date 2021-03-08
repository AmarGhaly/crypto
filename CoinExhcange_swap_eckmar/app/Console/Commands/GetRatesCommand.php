<?php

namespace App\Console\Commands;

use App\Jobs\GetRatesJob;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Log;

class GetRatesCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'rates';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Get rates';

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
        $this->info('Updating rates');
        try {
            GetRatesJob::dispatch();
        } catch (\Exception $exception){
            Log::error($exception);
            $this->error('Updating rates failed');
        }

    }
}
