<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\EducationController;
use App\Http\Controllers\RouteController;
use App\Http\Controllers\UserController;
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
    
    // USER
    Route::get('/admin/users', 'users')->middleware('admin');

    // QUIZ
    Route::get('/admin/quiz', 'quiz')->middleware('admin');
    Route::get('/admin/quiz/result', 'quiz_result')->middleware('admin');
    Route::get('/admin/quiz/question', 'quiz_question')->middleware('admin');

    // CATEGORY
    Route::get('/admin/category', 'category')->middleware('admin');
    
    
    // EDUCATION
    Route::get('/admin/education', 'education')->middleware('admin');

    // USER PAGE
    Route::get('/', 'index')->middleware('auth');
});

Route::controller(AuthController::class)->group(function(){
    Route::get('/login', 'login')->middleware('guest');
    Route::post('/signin', 'signin')->middleware('guest');
    Route::get('/register', 'register')->middleware('guest');
    Route::post('/signup', 'signup')->middleware('guest');
});

Route::controller(UserController::class)->group(function(){
    Route::post('/admin/user/create', 'store')->middleware('admin');
    Route::get('/admin/user/delete/{id}', 'destroy')->middleware('admin');
    Route::get('/admin/user/edit/{id}', 'show')->middleware('admin');
});

Route::controller(CategoryController::class)->group(function(){
    Route::post('/admin/category/create', 'store')->middleware('admin');
});