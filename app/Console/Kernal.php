<?php

namespace App\Console;

use App\Models\Payment;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;
use Illuminate\Console\Scheduling\Schedule;
use App\Jobs\ProcessPayments;

class Kernel extends ConsoleKernel
{
    protected function schedule(Schedule $schedule)
    {
        $schedule->call(function () {
            $scheduleEntry = Payment::where('status', 'pending')->where('is_scheduled',1)->first();

            if ($scheduleEntry && $scheduleEntry->is_scheduled) {
                ProcessPayments::dispatch();
            }
        })->dailyAt('13:00');
    }

    protected function commands()
    {
        $this->load(__DIR__.'/Commands');

        require base_path('routes/console.php');
    }
}





