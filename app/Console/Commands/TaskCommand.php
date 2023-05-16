<?php

namespace App\Console\Commands;

use Carbon\Carbon;
use Illuminate\Console\Command;
use App\Models\Task;
use App\Models\User;
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
            $user = User::where('id', $task->user_id)->first();

            $task->display = true;
            $task->save();

            $mailData = [
                'title' => 'You only have 5 minutes to finish your task!',
                'body' => $task->description
            ];
           
            \Mail::to($user->email)->send(new \App\Mail\NotificationMail($mailData));
           
            dd("Email is Sent.");
        }
    }
}