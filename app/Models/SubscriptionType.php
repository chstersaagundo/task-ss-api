<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SubscriptionType extends Model
{
    use HasFactory;

    protected $fillable = [
        'sub_type_name',
        'sub_type_desc',
        'interval',
        'sub_fee_price'
    ];

    public function subscriptions() {
        return $this->hasMany(Subscription::class);
    }
}