<?php

namespace App\Console\Commands;

use Carbon\Carbon;
use App\Models\Task;
use Illuminate\Console\Command;

class RunScheduledTasks extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'tasks:update-status';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Update task status if end date is lapas';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $now = Carbon::now();
        $tasks = Task::where('status', 'pending')
                    ->where('end_date', '<=', $now->toDateString())
                    ->where('end_time', '<', $now->toTimeString())
                    ->get();
    
        foreach ($tasks as $task) {
            $task->status = 'overdue';
            $task->save();
        }
    }

    
}