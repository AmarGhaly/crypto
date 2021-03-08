<?php

namespace App\Jobs;

use App\MorphTrade;
use App\Trade;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class UpdateTradeStatusJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * @var Trade
     */
    protected $trade;

    /**
     * @var MorphTrade
     */
    protected $morphTrade;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct(Trade $trade)
    {
        $this->trade = $trade;
        $this->morphTrade = $trade->morphTrade;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        try {
            DB::beginTransaction();
            $response = Trade\MorphTradeStatusUpdater::getResponse($this->trade);

            $this->morphTrade->setPropertiesFromResponse($response);
            $this->morphTrade->save();

            if ($this->morphTrade->state == 'COMPLETE') {
                $this->trade->state = Trade::getCompletedState();
            }
            if ($this->morphTrade->state == 'COMPLETE_WITH_REFUND' || $this->morphTrade->state == 'COMPLETE_WITHOUT_REFUND') {
                $this->trade->state = Trade::getRefundedState();
            }
            $this->trade->save();

            DB::commit();
        } catch (\Exception $exception) {
            DB::rollBack();
            Log::error($exception);
        }
    }
}
