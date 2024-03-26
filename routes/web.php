<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\RouteController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::controller(RouteController::class)->group(function(){
    Route::get('/admin/dashboard', 'admin_dashboard')->middleware('admin');
    Route::get('/admin/quiz', 'add_quiz')->middleware('admin');
    Route::get('/admin/users', 'users')->middleware('admin');
    
});

Route::controller(AuthController::class)->group(function(){
    Route::get('/login', 'login')->middleware('guest');
    Route::post('/signin', 'signin')->middleware('guest');
    Route::get('/register', 'register')->middleware('guest');
    Route::post('/signup', 'signup')->middleware('guest');
});
