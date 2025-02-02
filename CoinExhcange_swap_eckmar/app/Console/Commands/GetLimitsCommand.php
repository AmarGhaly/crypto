<?php

namespace App\Console\Commands;

use App\Jobs\GetLimitsJob;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Log;

class GetLimitsCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'limits';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Get limits';

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
        $this->info('Updating limits');
        try {
            GetLimitsJob::dispatch();
        } catch (\Exception $exception){
            Log::error($exception);
            $this->error('Updating limits failed');
        }
    }
}
