<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use App\Http\Requests\UserSignUpRequest;

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
            'user' => $user
        ], 201); // HTTP 201 Created
    }
}
