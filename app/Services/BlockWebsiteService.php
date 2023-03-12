<?php

namespace App\Services;

use App\Models\User;
use Illuminate\Support\Str;
use App\Models\BlockWebsite;
use Illuminate\Support\Facades\Auth;


class BlockWebsiteService
{
    
    public function create(array $data)
    {
        $user = Auth::user();
        $datas = User::where('email', $user->email)->first();
    
        BlockWebsite::create([
            'user_id' => $datas->id, 
            'website_link' => $data['website_link'],
            'website_name' => $data['website_name'],
            'is_include' => $data['is_include']
        ]);

        return $data;
    }
    
}
