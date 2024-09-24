<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\AssignmentController;
use App\Http\Controllers\PolicyController;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');


Route::post('/signup',[UserController::class,'signup']);
Route::post('/login',[UserController::class,'login']);

Route::middleware(['auth:sanctum','auth:api'])->group(function () {
Route::post('/file-upload',[UserController::class,'fileUpload']);
Route::get('/user-wallet/{user}',[UserController::class,'getWallet']);
Route::post('/profile-update/{user}',[UserController::class,'profileUpdate']);
Route::put('/changePassword/{user}',[UserController::class,'changePassword']);
Route::get('/serviceList',[AssignmentController::class,'serviceList']);
Route::post('/submit-assignment',[AssignmentController::class,'addOrder']);
Route::get('/assignmentList/{user}/{is_completed}',[AssignmentController::class,'assignmentList']);
Route::get('/assignmentStatusList',[AssignmentController::class,'assignmentStatusList']);
Route::get('/assignmentCounts',[AssignmentController::class,'AssignmentCounts']);
Route::get('/policy/{policy}',[PolicyController::class,'getPolicy']);
Route::post('/logout',[UserController::class,'logout']);

});