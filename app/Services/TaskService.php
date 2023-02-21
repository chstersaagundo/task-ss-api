<?php

namespace App\Services;

use App\Models\Task;
use App\Models\User;
use App\Models\Category;
use App\Models\TaskType;
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
        //retrieving the authenticated user
        $user = Auth::user();
        //getting the email from the authenticated user
        $datas = User::where('email', $user->email)->first();
        //getting the category user_id
        $category = Category::where('id', $datas->id)->first();
        
        //Save the task infos
        Task::create([
            'category_id' => $category->id, 
            'task_type_id' => $data['task_type_id'],
            'task_name' => $data['task_name'],
            'task_desc' => $data['task_desc'],
            'is_starred' => $data['is_starred'],
            'priority' => $data['priority'],
            'status' => $data['status'],
            'start_date' => $data['start_date'],
            'end_date' => $data['end_date'],
            'start_time' => $data['start_time'],
            'end_time' => $data['end_time'],
        ]);
        
        

        return $data;
    }


    
}
