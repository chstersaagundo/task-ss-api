<?php

namespace App\Console\Commands;

use Carbon\Carbon;
use App\Models\Task;
use App\Models\TaskScheduler;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Log;
// use Symfony\Component\Console\Input\InputOption;
// use Symfony\Component\Console\Input\InputArgument;
// use Symfony\Component\Console\Input\InputOption;

class RunScheduledTasks extends Command
{
    protected $signature = 'scheduled_task:run {--task_id=} {--repeat_type=} {--start_date=} {--start_time=}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Run scheduled tasks';

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {

        $taskId = $this->option('--task_id');
        $repeatType = $this->option('--repeat_type');
        $startDate = $this->option('--start_date');
        $startTime = $this->option('--start_time');

        // Find the task to run
        $task = Task::findOrFail($taskId);

        // Run the task
        Log::info("Running scheduled task: {$task->task_name}");

        // Perform any necessary task logic here...
        
        // Schedule the task to run again if necessary
        if ($repeatType == 'daily') {
            $nextRun = Carbon::parse($startDate)->addDay();
        } elseif ($repeatType == 'weekly') {
            $nextRun = Carbon::parse($startDate)->addWeek();
        } elseif ($repeatType == 'monthly') {
            $nextRun = Carbon::parse($startDate)->addMonth();
        } else {
            // Do not schedule another run
            return;
        }

        // Update the task with the next run date and time
        $task->start_date = $nextRun->format('Y-m-d');
        $task->start_time = $startTime;
        $task->save();

        // Schedule the task to run again
        $command = 'scheduled_task:run';
        $arguments = [
            '--task_id' => $taskId,
            '--repeat_type' => $repeatType,
            '--start_date' => $nextRun->format('Y-m-d'),
            '--start_time' => $startTime
        ];
        $this->call($command, $arguments);
    }

    // protected function configure()
    // {
    //     $this->setName('scheduled_task:run')
    //         ->setDescription('Run a scheduled task')
    //         ->addArgument('task_id', InputArgument::REQUIRED, 'The ID of the task to run')
    //         ->addArgument('repeat_type', InputArgument::REQUIRED, 'Type of repeat')
    //         ->addArgument('start_date', InputArgument::REQUIRED, 'Start date of the task')
    //         ->addArgument('start_time', InputArgument::REQUIRED, 'Start time of the task');
    // }

}
