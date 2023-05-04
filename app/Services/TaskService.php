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

    public function createTask(array $data)
    {
        //retrieving the authenticated user
        $user = Auth::user();
        //getting the email from the authenticated user
        $datas = User::where('email', $user->email)->first();
        $category = Category::where('user_id', $datas->id)->get();

        //Save the task infos
        Task::create([
            'category_id' => $category->id, //input id from a specific category
            'task_type_id' => $data['task_type_id'], //select task type (1 - to do list || 2 - to be done)
            'task_name' => $data['task_name'],
            'task_desc' => $data['task_desc'],
            'is_starred' => $data['is_starred'], // 1 - starred || 0 - not
            'priority' => $data['priority'], //level of priority (bornz ay)
            'status' => $data['status'], // completed || pending || abandoned
            'start_date' => $data['start_date'], // Y-m-d { ex. 2023-12-12 }
            'end_date' => $data['end_date'], // Y-m-d ex. { 2023-12-13 }
            'start_time' => $data['start_time'], // H:i:s { ex. 18:59:32 }
            'end_time' => $data['end_time'], // H:i:s { ex. 19:00:14 }
            'repeat_type' => $data['repeat_type'],
        ]);
              
        return $data;
    }


    
}
