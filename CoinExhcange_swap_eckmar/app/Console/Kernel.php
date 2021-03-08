<?php

namespace App\Console;

use App\Console\Commands\CheckPaymentForPendingTradesCommand;
use App\Console\Commands\GetRatesCommand;
use App\Console\Commands\ProcessPaymentsWithEnoughBalanceCommand;
use App\Console\Commands\UpdateBalanceForPendingTradesCommand;
use App\Console\Commands\UpdateSentTransactionsCommand;
use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;

class Kernel extends ConsoleKernel
{
    /**
     * The Artisan commands provided by your application.
     *
     * @var array
     */
    protected $commands = [
        //
    ];

    /**
     * Define the application's command schedule.
     *
     * @param  \Illuminate\Console\Scheduling\Schedule  $schedule
     * @return void
     */
    protected function schedule(Schedule $schedule)
    {
        $schedule->command(GetRatesCommand::class)->everyFiveMinutes();
        $schedule->command(CheckPaymentForPendingTradesCommand::class)->everyMinute()->withoutOverlapping();
        $schedule->command(UpdateBalanceForPendingTradesCommand::class)->everyFiveMinutes()->withoutOverlapping();
        $schedule->command(ProcessPaymentsWithEnoughBalanceCommand::class)->everyFiveMinutes()->withoutOverlapping();
        $schedule->command(UpdateSentTransactionsCommand::class)->everyTenMinutes()->withoutOverlapping();
    }

    /**
     * Register the commands for the application.
     *
     * @return void
     */
    protected function commands()
    {
        $this->load(__DIR__.'/Commands');

        require base_path('routes/console.php');
    }
}
