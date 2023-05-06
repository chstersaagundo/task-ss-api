<?php

namespace App\Console\Commands;

use Carbon\Carbon;
use Illuminate\Console\Command;
use App\Models\Task;
use App\Models\Subscription;
use Illuminate\Support\Facades\Auth;
class NotificationCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'tasks:notification';

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
        $tasks = Subscription::where('status', 'active')
                    ->where('end_date', '<=', $now->toDateString())
                    ->get();
    
        foreach ($tasks as $task) {
            $task->status = 'expired';
            $task->save();
        }
    }
}
