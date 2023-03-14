<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\User;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;

use App\Http\Requests\UserRequest;
use App\Http\Requests\ChangePasswordRequest;
use App\Services\UserService;

/**
 * @group User
 *
 * API for managing user(s)
 */
class UserController extends Controller
{
    private UserService $userService;

    public function __construct(UserService $userService)
    {
        $this->userService = $userService;
    }

    public function getProfile()
    {
        $user = Auth::user();

        return response()->json([
            "success" => true,
            "message" => "User Profile",
            "data"    => $user
        ]);
    }

    
    // public function updateProfile(UserRequest $request)
    // {
    //     $data = $request->validated();
    //     $user = Auth::user();

    //     $data['user_id'] = $user->id;
    //     logger()->info($data);

    //     $user_details = $this->userService->update_user_details($data);

    //     return response()->json([
    //         "success" => true,
    //         "message" => "Update Successful.",
    //         "data"    => new UserDetailResource($user_details)
    //     ]);
    // }

    public function getAllUsers()
    {
        return response()->json([
            "success" => true,
            "message" => "Fetch Successfully",
            "data" => User::all()
        ]);
    }

    
    public function changePassword(ChangePasswordRequest $request)
    {
        $data = $request->validated();
        $user = Auth::user();

        if( Hash::check($data['new_password'],$user->password) ){
            return response()->json([
                "success" => false,
                "message" => "Password can not be same as old password.",
            ], 200);
        }

        $this->userService->change_password($data);

        return response()->json([
            "success" => true,
            "message" => "Password has been successfully changed"
        ]);
    }

    public function updateProfile(UserRequest $request)
    {
        $user = Auth::user();
        
        $user->update($request->all());
                
        return response()->json([
            'success' => true,
            'message' => 'User Successfully Updated',
            'data' => $user
        ], 200);

    }


}
