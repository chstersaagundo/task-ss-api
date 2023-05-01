<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Subscription extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'subscription_type_id',
        'status',
        'end_date'
    ];
    
    public function subscription_type() {
        return $this->belongsTo(SubscriptionType::class);
    }

    public function user() {
        return $this->belongsTo(User::class);
    }

}