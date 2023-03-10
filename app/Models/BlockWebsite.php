<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BlockWebsite extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'website_link',
        'website_name',
        'is_include'
    ];

    protected $casts = [
        'is_verified' => 'boolean',
    ];

    public function user() {
        return $this->belongsTo(User::class);
    }
}
