<?php

namespace App\Services;

use App\Models\User;
use App\Models\Feedback;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Auth;


class FeedbackService
{
    
    public function create(array $data)
    {
        $user = Auth::user();
        $datas = User::where('email', $user->email)->first();
    
        Feedback::create([
            'user_id' => $datas->id, 
            'comments' => $data['comments'],
            'ratings' => $data['ratings']
        ]);

        return $data;
    }
    
}
