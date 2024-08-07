<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\EducationController;
use App\Http\Controllers\QuestionController;
use App\Http\Controllers\QuizController;
use App\Http\Controllers\RouteController;
use App\Http\Controllers\UserAnswerController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Redirect;

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


Route::controller(RouteController::class)->group(function () {
    // ADMIN
    Route::get('/admin/dashboard', 'admin_dashboard')->middleware('admin');
    Route::get('/admin/profile', 'admin_profile')->middleware('admin');

    // USER
    Route::get('/admin/users', 'users')->middleware('admin');

    // QUIZ
    Route::get('/admin/quiz', 'quiz')->middleware('admin');
    Route::get('/admin/quiz/result', 'quiz_result')->middleware('admin');
    Route::get('/admin/quiz/review', 'quiz_review')->middleware('admin');

    // CATEGORY
    Route::get('/admin/category', 'category')->middleware('admin');

    // EDUCATION
    Route::get('/admin/education', 'education')->middleware('admin');

    // USER PAGE
    Route::get('/home', 'index')->middleware('auth');
    Route::get('/quiz', 'user_quiz')->middleware('auth');
    Route::get('/score', 'user_score')->middleware('auth');
    // Route::get('/quiz/{slug}', 'user_quiz_page')->middleware('auth');

    // QUIZ REVIEW TABLE
    Route::get('/admin/quiz/review/{slug}/{userId}', [QuizController::class, 'quizReviewIndex'])->middleware('auth:sanctum');
});

Route::controller(AuthController::class)->group(function () {
    Route::get('/', 'login')->middleware('guest')->name('login');
    Route::post('/signin', 'signin')->middleware('guest');
    Route::get('/register', 'register')->middleware('guest');
    Route::post('/signup', 'signup')->middleware('guest');
});

Route::middleware('auth:sanctum')->group(function () {
    // ADMIN ONLY
    Route::middleware('admin')->group(function () {
        Route::controller(UserController::class)->group(function () {
            Route::post('/admin/user/create', 'store');
            Route::get('/admin/user/delete/{id}', 'destroy');
            Route::get('/admin/user/edit/{id}', 'show');
            Route::post('/admin/user/edit/{id}', 'update');
            Route::post('/admin/profile/edit/{id}', 'editProfile');
            Route::post('/admin/profile/{id}', 'edit');
            Route::get('/admin/users', 'index');
        });

        Route::controller(EducationController::class)->group(function () {
            Route::post('/admin/education/create', 'store');
            Route::get('/admin/education/delete/{id}', 'destroy');
            Route::put('/admin/education/edit/{id}', 'update');
            Route::get('/admin/education', 'index');
        });

        Route::controller(CategoryController::class)->group(function () {
            Route::post('/admin/category/create', 'store');
            Route::get('/admin/category/delete/{id}', 'destroy');
            Route::put('/admin/category/edit/{id}', 'update');
            Route::get('/admin/category', 'index');
        });

        Route::controller(QuestionController::class)->group(function () {
            Route::post('/admin/quiz/question/create', 'store');
            Route::post('/admin/quiz/question/create/essay', 'essayStore');
            Route::post('/admin/quiz/question/create/weighted', 'weightedStore');
            Route::post('/admin/quiz/question/edit/{id}', 'update');
            Route::post('/admin/quiz/question/edit/essay/{id}', 'essayUpdate');
            Route::post('/admin/quiz/question/edit/weighted/{id}', 'weightedUpdate');
            Route::get('/admin/quiz/{slug}', 'show');
            Route::get('/admin/quiz/question/delete/{id}', 'destroy');
        });
    });

    // END ADMIN ONLY

    Route::controller(AuthController::class)->group(function () {
        Route::get('/logout', 'logout')->middleware('auth');
    });

    Route::controller(QuizController::class)->group(function () {
        Route::post('/admin/quiz/create', 'store')->middleware('admin');
        Route::post('/admin/quiz/edit/{id}', 'update')->middleware('admin');
        Route::get('/admin/quiz/delete/{id}', 'destroy')->middleware('admin');
        Route::get('/admin/quizzes', 'adminIndex')->name('quiz.adminIndex')->middleware('admin'); // Add the new route here
        Route::get('/admin/quiz', 'quizSearch')->middleware('admin');
        Route::get('/admin/quiz/date/{quizId}', 'getParticipants')->middleware('admin');
        Route::get('/quiz/view/{slug}/{number}', 'quiz_num');
        Route::post('/quiz/view/{slug}', 'quiz_view');
        Route::get('/quiz/filter', 'index')->name('quiz.filter');
    });

    Route::controller(UserAnswerController::class)->group(function () {
        Route::post('/quiz/{id}/answer', 'store')->middleware('auth');
        Route::post('/quiz/{id}/essayAnswer', 'storeEssayAnswer')->middleware('auth');
        Route::get('/quiz/{id}/thumbnail', [QuizController::class, 'showThumbnail',])->name('quiz.thumbnail');
        Route::post('/quiz', function () {
            return Redirect::to('/quiz');
        })->name('submit_quiz');
        Route::post('/quiz/{quiz_id}/deleteAnswer', 'deleteAnswer')->name('quiz.deleteAnswer');
    });
});
