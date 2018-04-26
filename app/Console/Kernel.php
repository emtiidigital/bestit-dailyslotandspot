<?php

namespace App\Console;

use Carbon\Carbon;
use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;
use Illuminate\Support\Facades\Schema;

class Kernel extends ConsoleKernel
{
    /**
     * The Artisan commands provided by your application.
     *
     * @var array
     */
    protected $commands = [
        Commands\SendMessage::class,
        Commands\ResetCounter::class
    ];

    /**
     * Define the application's command schedule.
     *
     * @param  \Illuminate\Console\Scheduling\Schedule $schedule
     * @return void
     */
    protected function schedule(Schedule $schedule)
    {
        //TODO: fix
/*        if (Schema::hasTable('reminders')) {
            $reminder = \App\Reminder::find(1);
            $resetTime = Carbon::parse($reminder->beginning_time)->subHour()->format('H:i');
            $beginningTime = Carbon::parse($reminder->beginning_time)->subMinutes($reminder->hip_chat)->format('H:i');

            $schedule->command('bestit:reset:Reminder')
                ->weekdays()
                ->at($resetTime);

            $schedule->command('bestit:send:workers_Message')
                ->weekdays()
                ->everyTenMinutes()
                ->between($beginningTime, $reminder->end_time);
        }*/
    }

    /**
     * Register the Closure based commands for the application.
     *
     * @return void
     */
    protected function commands()
    {
        require base_path('routes/console.php');
    }
}
