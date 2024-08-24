<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use App\Http\Requests\UserSignUpRequest;
use App\Http\Requests\UserLoginRequest;
use App\Http\Requests\ImageUploadRequest;
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
    public function login(UserLoginRequest $request){
        
        if(Auth::attempt(['email' => $request->email, 'password' => $request->password])){
            $user=Auth::user();
            $user->access_token = $user->createToken('Personal Access Token')->plainTextToken;
            return response()->json([
                'code' => 200,
                'message' => 'Login Successfully',
                'data' => $user 
            ],200);
        }else{
            return response()->json([
                'code' => 401,
                'message' => 'Unauthorized',
                'error' => 'Invalid email or password.'
            ], 401);
        }
    }

    public function imageUpload(ImageUploadRequest $request){

        if ($request->hasFile('image')) {
            $image = $request->file('image');
            
            $filename = time() . '.' . $image->getClientOriginalExtension();
            
            $image->move(public_path('images'), $filename);
    
            return response()->json([
                'success' => true,
                'message' => 'Image uploaded successfully',
                'image_path' => 'images/' . $filename
            ]);
        } else {
            return response()->json([
                'success' => false,
                'message' => 'No image file found in request'
            ], 400);
        }

    }
}
