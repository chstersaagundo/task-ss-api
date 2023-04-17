<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Console\View\Components\Task;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class TaskScheduler extends Model
{
    use HasFactory;

    protected $fillable = [
        'task_id',
        'hour',
        'day',
        'month',
        'day_of_week',
    ];

    // public function task()
    // {
    //     return $this->belongsTo(Task::class);
    // }
}
