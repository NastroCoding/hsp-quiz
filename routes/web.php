<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\EducationController;
use App\Http\Controllers\QuizController;
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

// DEFAULT ROUTE (/home)

Route::controller(RouteController::class)->group(function(){
    // ADMIN
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
    Route::get('/home', 'index')->middleware('auth');
    Route::get('/quiz', 'user_quiz')->middleware('auth');
    Route::get('/score', 'user_score')->middleware('auth');
    Route::get('/quiz_page', 'user_quiz_page')->middleware('auth');
});

Route::controller(AuthController::class)->group(function(){
    Route::get('/', 'login')->middleware('guest')->name('login');
    Route::post('/signin', 'signin')->middleware('guest');
    Route::get('/register', 'register')->middleware('guest');
    Route::post('/signup', 'signup')->middleware('guest');
    Route::get('/logout', 'logout')->middleware('auth');
});

Route::controller(UserController::class)->group(function(){
    Route::post('/admin/user/create', 'store')->middleware('admin');
    Route::get('/admin/user/delete/{id}', 'destroy')->middleware('admin');
    Route::get('/admin/user/edit/{id}', 'show')->middleware('admin');
    Route::post('/admin/user/edit/{id}', 'update')->middleware('admin');
});

Route::controller(QuizController::class)->group(function(){
    Route::post('/admin/quiz/create', 'store')->middleware('admin');
});

Route::controller(CategoryController::class)->group(function(){
    Route::post('/admin/category/create', 'store')->middleware('admin');
    Route::get('/admin/category/delete/{id}', 'destroy')->middleware('admin');
    Route::put('/admin/category/edit/{id}', 'update')->middleware('admin');
});

Route::controller(EducationController::class)->group(function(){
    Route::post('/admin/education/create', 'store')->middleware('admin');
    Route::get('/admin/education/delete/{id}', 'destroy')->middleware('admin');
    Route::put('/admin/education/edit/{id}', 'update')->middleware('admin');
});
