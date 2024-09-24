<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use App\Models\Wallet;
use App\Http\Requests\UserSignUpRequest;
use App\Http\Requests\UserLoginRequest;
use App\Http\Requests\ImageUploadRequest;
use App\Http\Requests\ProfileUpdateRequest;
use App\Http\Requests\ChangePasswordRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class UserController extends Controller
{


    /**
     * Handle user sign-up.
     *
     * @param  UserSignUpRequest  $request
     * @return \Illuminate\Http\JsonResponse
     */

    function index() {
        $title='Users';
        return view('users',compact('title'));
    }
    public function signup(UserSignUpRequest $request)
    {
        try{
            DB::beginTransaction();
            $user = User::create([
                'role_id' => 2,
                'name' => $request->name,
                'email' => $request->email,
                'dob' => $request->dob,
                'plate_form' => $request->plate_form??'web',
                'country_code' => $request->country_code,
                'country_flag' => $request->country_flag,
                'contact' => $request->contact,
                'ip_address' => $request->ip(),
                'password' => Hash::make($request->password),
            ]);
            if($user){
               $wallet=Wallet::create(['user_id'=>$user?->id, 'balance'=>0.00]);
            }
            DB::commit();
            // Return a success response
            return response()->json([
                'message' => 'User created successfully.',
                'code' => 201
            ], 201);
        }catch(Exception $e) {
            DB::rollback();
            return response()->json([
                'success' => false,
                'message' => 'Something went wrong please try later.'
            ], 400);
        }
        
    }

    //login
    public function login(UserLoginRequest $request)
    {
        // Attempt to authenticate the user
        if (Auth::attempt(['email' => $request->email, 'password' => $request->password])) {
            // Get the authenticated user
            $user = Auth::user();
            if($user->image){
                $user->image = asset('storage/' . $user->image);
            }
            // Create a personal access token
            $user->token= $user->createToken('Personal Access Token')->plainTextToken;
            
            // Return the response with the token and user data
            return response()->json([
                'code' => 200,
                'message' => 'Login successfully',
                'data' => [
                    'user' => $user
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

    public function fileUpload(ImageUploadRequest $request){

        if ($request->hasFile('attachment')) {
            $folder='';

            $attachment = $request->file('attachment');
            if(in_array($request->attachment->getClientOriginalExtension(),['jpg', 'jpeg', 'png'])){
                $folder='images';
            }else{
                $folder='attachments';
            }
            
            $filename = time() . '.' . $attachment->getClientOriginalExtension();
            
            $attachment->move(public_path($folder), $filename);
    
            return response()->json([
                'success' => true,
                'message' => 'File uploaded successfully',
                'file_path' =>  $folder.'/' . $filename
            ]);
        } else {
            return response()->json([
                'success' => false,
                'message' => 'No file found in request'
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



    function userList(Request $request)
    {
        $users = User::where('role_id',2)->paginate($request->input('length', 10)); // Default is 10 records per page
    
        return response()->json([
            'draw' => intval($request->input('draw')),
            'recordsTotal' => $users->total(),
            'recordsFiltered' => $users->total(),
            'data' => $users->items(),
        ]);
    }
    
    public function destroy(User $user)
    {
        $user->delete();
        return response()->json(['success' => true, 'message' => 'User deleted successfully']);
    }

    public function profileUpdate(Request $request, User $user) {
 
        try{

            if ($request->has('name')) {
                $user['name'] = $request->name;
            }
            if ($request->has('country_code')) {
                $user['country_code'] = $request->country_code;
            }
            if ($request->has('contact')) {
                $user['contact'] = $request->contact;
            }
            if ($request->hasFile('image')) {
                $user['image'] = $request->file('image')->store('images', 'public'); // Adjust the path as needed
            }

            $user->save();
 
        } 
        catch(Exception $e) {
           dd($e);
        }

    }
    public function changePassword(ChangePasswordRequest $request, User $user) {
        try{

            $user=User::update([
                'password' => Hash::make($request->newPassword)
            ]);
            return response()->json(['success'=>true, 'message' => 'Password changed successfully!'], 200);
        } 
        catch(Exception $e) {
            return response()->json(['success'=>false, 'message' => 'Someting went wrong. Please try later'], 400);
        }

    }
    
   
    public function show($id) {
        $user = User::find($id);
        if ($user) {
            return response()->json($user);
        }
        return response()->json(['message' => 'User not found'], 404);
    }

    public function logout(Request $request)
    {
        // Revoke the user's current token
        $request->user()->currentAccessToken()->delete();

        return response()->json(['success' => true, 'message' => 'Logged out successfully.']);
    }

}
