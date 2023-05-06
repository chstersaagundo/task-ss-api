<?php

namespace App\Console\Commands;

use Carbon\Carbon;
use Illuminate\Console\Command;
use App\Models\Task;
use App\Models\Notification;


class TaskCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'tasks:tasks';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $now = Carbon::now();
        $tasks = Notification::where('display', false)
                    ->where('triggerdate', '<=', $now)
                    ->get();
    
        foreach ($tasks as $task) {
            $task->display = true;
            $task->save();
        }
    }
}
