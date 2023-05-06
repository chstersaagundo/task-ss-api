<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Notification extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'task_id',
        'status',
        'description',
        'display',
        'triggerdate'
    ];

    public function user() {
        return $this->belongsTo(User::class);
    }

    public function task()
    {
        return $this->hasOne(Task::class);
    }
}
