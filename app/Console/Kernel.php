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
        \serranatural\Commands\log_votos::class,
        \serranatural\Commands\email_preferencias::class,
        \serranatural\Commands\email_pratoDoDia::class,
        \serranatural\Commands\email_Microcity::class,
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
                     ->dailyAt('10:01');

            $schedule->command('email_Microcity')
                     ->dailyAt('21:40');
        }

    }

