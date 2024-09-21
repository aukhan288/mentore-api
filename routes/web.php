<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\AssignmentController;

// Route::get('/', function () {
//     return view('welcome');
// });

Route::get('/login', function () {
    return view('login');
});

Auth::routes();

Route::get('/', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
Route::get('/users', [UserController::class, 'index']);
Route::get('/orders', [AssignmentController::class, 'index']);
Route::get('/userList', [UserController::class, 'userList']);
Route::get('/orderList', [AssignmentController::class, 'orderList']);
Route::delete('/users/{user}', [UserController::class, 'destroy']);
Route::get('/users/{user}', [UserController::class, 'show']);
Route::get('/assignment/{id}', [AssignmentController::class, 'show']);
