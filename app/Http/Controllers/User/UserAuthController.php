<?php

namespace App\Http\Controllers\User;
use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests\LoginRequest;
use App\Http\Requests\UserRequest;
use App\Services\UserService;


/**
 * @group Authentication
 * 
 * API for managing authentication
 */
class UserAuthController extends Controller{
    private const API_TOKEN = 'user_security_token_88';
    private UserService $userService;

    public function __construct(UserService $userService){
        $this->userService = $userService;
    }   

    /**
     * Register
     *
     * This endpoint will create a new user but not yet activated and verified.
     *
     * @response scenario=success {
     *  "status": 200,
     *  "message": "Registration successful",
     * }
     * 
     *
     * @response status=422 scenario="email taken" {
     *  "message": "The email has already been taken.",
     *  "errors": {
     *      "email": [ "The email has already been taken." ]
     *  }
     * }
     * 
     * 
     * @response status=422 scenario="password does not match" {
     *  "message": "The password confirmation does not match.",
     *  "errors": {
     *      "email": [ "The password confirmation does not match." ]
     *  }
     * }
     */
    public function register(UserRequest $request) {
      

        if($request->validated()) {

            $this->userService->create($request->validated());

            return response()->json([
                'success' => true,
                'message' => 'Registration Successful!'
            ], 200);
        }
        
        return response()->json([
            'success' => false,
            'message' => 'Request not valid'
        ], 422);
  
    }    

    public function login(LoginRequest $request){
        $data = $request->validated();

        //Check email if it exist
        $isEmailExist = $this->userService->check_email_exist($data['email']);
        if(!$isEmailExist)
        {
            return response()->json([
                'success' => false,
                'message' => "Email and/or password is incorrect.",
            ], 422);
        }

        if (!Auth::attempt($data)) {
            return response()->json([
                'success' => false,
                'message' => "Email and/or password is incorrect."
            ], 422);
        }

        //Get authenticated user
        $user = Auth::user();

        //Call method to log login data
        $this->userService->user_login($user->email);

        $user_auth_token = $user->createToken(self::API_TOKEN)->plainTextToken;

        //User::where('email', $user->email)->whereNull('remember_token')->update(['remember_token' => $user_auth_token]);
        return response()->json([
            "success" => true,
            "message" => "Authentication Successful",
            "data" => [
                "token" => $user_auth_token,
                "id" => $user->id,
                "email" => $user->email,
                "firstname" => $user->firstname,
                "lastname" => $user->lastname,
                "phone" => $user->phone,
                "role_id" => $user->role_id
            ]
        ]);
    }

    public function logout(){
        $user = Auth::user();
        $this->userService->user_logout($user->email);

        auth()->user()->tokens()->delete();

        return response()->json([
            "success" => true,
            "message" => "Logout Successful"
        ]);
    }

}
