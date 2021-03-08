<?php

namespace App\Jobs;

use App\Trade;
use Carbon\Carbon;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class CancelOldTrade implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * After how many hours to delete the trade in pending state
     * @var int
     */
    protected $deleteOlderThan;
    /**
     * @var Trade
     */
    protected $trade;
    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct(Trade $trade,$deleteOlderThan = null)
    {
        $this->trade = $trade;
        if ($deleteOlderThan == null){
            $this->deleteOlderThan = 24;
        } else {
            $this->deleteOlderThan = $deleteOlderThan;
        }
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $hourDifference = $this->trade->created_at->diffInHours(Carbon::now(), false);
        if ($this->trade->isPending() && $hourDifference > $this->deleteOlderThan){
            $this->trade->state = Trade::getCanceledState();
            $this->trade->save();
        }
    }
}
