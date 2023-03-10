<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'category_name',
        'category_desc',
        'color'
    ];

    public function tasks() {
        return $this->hasMany(Task::class);
    }

    
}
