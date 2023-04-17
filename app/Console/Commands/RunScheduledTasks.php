<?php

namespace App\Console\Commands;

use App\Models\TaskScheduler;
use Illuminate\Console\Command;

class RunScheduledTasks extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'tasks:run-scheduled';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Run scheduled tasks';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $now = now();
        $schedules = TaskScheduler::where('hour', $now->hour)
            ->where('day', $now->day)
            ->where('month', $now->month)
            ->where('day_of_week', $now->dayOfWeek)
            ->get();

        foreach ($schedules as $schedule) {
            $schedule->task->run();
        }
    }
}
