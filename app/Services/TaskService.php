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

    public function createTask(array $data)
    {
        //Get the user by its name
        $user = User::where('name', 'user')->first();

        //Save the user infos
        Category::create([
            //kay basta gikuha ang id sa role tas gi create sa db hahaha kapoy english2
            'user_id' => $user->id, 
            'category_name' => $data['category_name'],
            'category_desc' => $data['category_desc'],
            'color' => $data['color']
        ]);

        return $user;
    }

    

    //LOGGING USER IN
    public function user_login(string $email) 
    {
        
        if($this->check_email_exist($email))
        {
            $user = User::where('email', $email)->first();

            UserLogin::create([
                "user_id" => $user->id,
                "device" => 'mobile',
                "logged_in_at" => now()
            ]);
        }
        
    }

    //LOGOUT USER
    public function user_logout(string $email)
    {
        if($this->check_email_exist($email))
        {
            $user = User::where('email', $email)->first();

            UserLogout::create([
                "user_id" => $user->id,
                "device" => 'mobile',
                "logged_out_at" => now()
            ]);
        }
    }
    
}
