<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use App\Http\Requests\UserSignUpRequest;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{


    /**
     * Handle user sign-up.
     *
     * @param  UserSignUpRequest  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function signup(UserSignUpRequest $request)
    {
        // Create the user with hashed password
        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
        ]);

        // Return a success response
        return response()->json([
            'message' => 'User created successfully.',
            'code' => 201
        ], 201); // HTTP 201 Created
    }

    //login
    public function login(Request $request){
        
        if(Auth::attempt(['email' => $request->email, 'password' => $request->password])){
            $user=Auth::user();
            $user->access_token = $user->createToken('Personal Access Token')->plainTextToken;
            return response()->json([
                'code' => 200,
                'message' => 'Login Successfully',
                'data' => $user 
            ],200);
        }else{
          dd('login failed');
        }
    }
}
