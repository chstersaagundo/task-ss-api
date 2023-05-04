<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Task extends Model
{
    use HasFactory;

    protected $fillable = [
        'category_id',
        'task_type_id',
        'user_id',
        'task_name',
        'task_desc',
        'is_starred',
        'priority',
        'status',
        'start_date',
        'end_date',
        'start_time',
        'end_time',
        'repeat_type',
    ];

    public function category() {
        return $this->belongsTo(Category::class);
    }

    public function user() {
        return $this->belongsTo(User::class);
    }

    public function task_type() {
        return $this->belongsTo(TaskType::class);
    }
}
