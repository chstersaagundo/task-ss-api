<?php

namespace App\Services;

use App\Models\Task;
use App\Models\User;
use App\Models\Category;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Auth;
//use \Laravel\Sanctum\PersonalAccessToken;


class TaskService
{
    
    //CREATING CATEGORY TO THE DATABASE
    public function create(array $data)
    {
        //retrieving the authenticated user
        $user = Auth::user();
        //getting the email from the authenticated user
        $datas = User::where('email', $user->email)->first();
        
        //Save the category infos
        Category::create([
            'user_id' => $datas->id, 
            'category_name' => $data['category_name'],
            'category_desc' => $data['category_desc'],
            'color' => $data['color']
        ]);

        return $data;
    }

    //Wala pa ni, char2 ra ni hahaha
    public function createTask(array $data)
    {
        $user = User::where('name', 'user')->first();
        Category::create([
            'user_id' => $user->id, 
            'category_name' => $data['category_name'],
            'category_desc' => $data['category_desc'],
            'color' => $data['color']
        ]);

        return $user;
    }


    
}
