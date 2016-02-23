<?php

namespace serranatural\Console;

use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;

use DB;

class Kernel extends ConsoleKernel
{
    /**
     * The Artisan commands provided by your application.
     *
     * @var array
     */
    protected $commands = [
        \serranatural\Console\Commands\Inspire::class,
        \serranatural\Commands\email_pratoDoDia::class,
        \serranatural\Commands\conta_a_pagar::class,
    ];

    /**
     * Define the application's command schedule.
     *
     * @param  \Illuminate\Console\Scheduling\Schedule  $schedule
     * @return void
     */
    protected function schedule(Schedule $schedule)
        {
            $schedule->command('inspire')
                     ->hourly();

            $schedule->command('email_pratoDoDia')
                     ->dailyAt('09:09');

            $schedule->command('conta_a_pagar')
                     ->dailyAt('11:09');


        }

    }

