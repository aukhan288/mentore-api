<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');


Route::post('/signup',[App\Http\Controllers\UserController::class,'signup']);
Route::post('/login',[App\Http\Controllers\UserController::class,'login']);

Route::post('/image-upload',[App\Http\Controllers\UserController::class,'imageUpload']);
Route::post('/update-profile',[App\Http\Controllers\UserController::class,'imageUpload']);
