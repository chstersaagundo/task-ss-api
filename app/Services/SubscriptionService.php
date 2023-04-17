<?php

namespace App\Services;

use App\Models\User;
use Illuminate\Support\Str;
use App\Models\Subscription;
use App\Models\SubscriptionType;
use Illuminate\Support\Facades\Auth;

//use \Laravel\Sanctum\PersonalAccessToken;


class SubscriptionService
{
    
    public function create()
    {
        $user = Auth::user();
        $sub_type = SubscriptionType::all();

        Subscription::create([
            'user_id' => $user->id, 
            'sub_type_id' => '1'
        ]);

        
    }



    

    
}
