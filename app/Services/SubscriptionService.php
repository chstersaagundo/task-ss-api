<?php

namespace App\Services;

use App\Models\User;
use Illuminate\Support\Str;
use App\Models\Subscription;
use App\Models\SubscriptionType;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

class SubscriptionService
{
    public function checkActiveSubscription() {
        $user = Auth::user();
        $sub = Subscription::where('user_id', $user->id)
        ->where('status', 'active')->get();

        return $sub->isNotEmpty();
    }
    
    public function create(array $data)
    {
        $user = Auth::user();
        $date = Carbon::now();
        $sub_type = SubscriptionType::where('id', $data['subscription_type_id'])->first();

        if($sub_type->interval == "month") {
            $date->addMonth();
        }

        if($sub_type->interval == "year") {
            $date->addYear();
        }

        return Subscription::create([
            'user_id' => $user->id, 
            'subscription_type_id' => $sub_type->id,
            'status' => 'active',
            'end_date' => $date->format('Y-m-d H:i:s'),
        ]);
    }
    
}