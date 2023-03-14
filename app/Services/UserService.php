<?php

namespace App\Services;

use Illuminate\Support\Str;
use App\Models\User;
use App\Models\Role;
use App\Models\UserLogin;
use App\Models\UserLogout;
//use \Laravel\Sanctum\PersonalAccessToken;


class UserService
{
    
    //CREATING USER TO THE DATABASE
    public function create(array $data)
    {
        $data['password']   = bcrypt($data['password']);

        //Get the user by its name
        $role = Role::where('name', 'user')->first();

        //Save the user infos
        User::create([
            //kay basta gikuha ang id sa role tas gi create sa db hahaha kapoy english2
            'role_id' => $role->id, 
            'firstname' => $data['firstname'],
            'lastname' => $data['lastname'],
            'password' => $data['password'],
            'email' => $data['email'],
            'phone' => $data['phone'],
            'trial_card' => true,
            'is_verified' => false,

        ]);

        return $role;
    }

    //CHECKING EMAIL IF IT EXISTS IN DATABASE
    public function check_email_exist(string $email)
    {
        return User::where('email', $email)->exists();
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
    
    public function change_password(array $data)
    {
        if($this->check_email_exist($data['email']))
        {
            $user = User::where('email',$data['email'])->first();

            $user->password = bcrypt($data['new_password']);
            $user->save();
        }
    }

    
}
