<?php

namespace App\Http\Controllers\User;

use App\Models\User;
use Illuminate\Http\Request;

use App\Services\UserService;
use App\Http\Requests\UserRequest;
use App\Http\Controllers\Controller;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Http\Requests\RegisterRequest;
use App\Http\Requests\ChangePasswordRequest;

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

        // $user = User::find($id);
        // if ($user){
        //     $user->update($request->all());
        //     return response()->json([
        //         'success' => true,
        //         'message' => 'User Successfully Updated',
        //         'data' => $user
        //     ], 200);
        // }

        // return response()->json([
        //     'success' => false,
        //     'message' => 'User not found'
        // ], 404);

    }

    public function destroy($id)
    {
        User::where('id', $id)->delete();
        auth()->user()->tokens()->delete();
        return response()->json([
            'success' => true,
            'message' => 'User Removed Successfully',
            'data' => $id
        ], 200);
    }

}
