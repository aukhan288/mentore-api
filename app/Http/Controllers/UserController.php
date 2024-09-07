<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use App\Models\Wallet;
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
            'role_id' => 2,
            'name' => $request->name,
            'email' => $request->email,
            'dob' => $request->dob,
            'plate_form' => $request->plate_form??'web',
            'country_code' => $request->country_code,
            'contact' => $request->contact,
            'ip_address' => $request->ip(),
            'password' => Hash::make($request->password),
        ]);

        // Return a success response
        return response()->json([
            'message' => 'User created successfully.',
            'code' => 201
        ], 201); // HTTP 201 Created
    }

    //login
    public function login(UserLoginRequest $request)
    {
        // Attempt to authenticate the user
        if (Auth::attempt(['email' => $request->email, 'password' => $request->password])) {
            // Get the authenticated user
            $user = Auth::user();
            
            // Create a personal access token
            $token = $user->createToken('Personal Access Token')->plainTextToken;

            // Return the response with the token and user data
            return response()->json([
                'code' => 200,
                'message' => 'Login successfully',
                'data' => [
                    'user' => $user,
                    'token' => $token
                ]
            ], 200);
        } else {
            // Return unauthorized response if authentication fails
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
    public function getWallet($user){

        try {
            $wallet = Wallet::where('user_id', $user)->first();
            return response()->json([
                'success' => true,
                'wallet' => $wallet
            ]);
        } catch(Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'No image file found in request'
            ], 400);
        }

    }
}
