<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Education;
use App\Models\Quiz;
use App\Models\User;
use Illuminate\Http\Request;

class RouteController extends Controller
{
    public function admin_dashboard()
    {
        return view('admin.dashboard', [
            'page' => 'Dashboard'
        ]);
    }

    public function quiz()
    {
        $category = Category::latest()->get();
        $education = Education::latest()->get();
        $quiz = Quiz::latest()->get();
        return view('admin.quiz.quiz', [
            'page' => 'Quiz',
            'category' => $category,
            'education' => $education,
            'data' => $quiz
        ]);
    }

    // QUIZ

    public function users()
    {
        $user = User::latest()->get();
        $education = Education::latest()->get();
        return view('admin.user.users', [
            'page' => 'Users',
            'data' => $user,
            'education' => $education
        ]);
    }
    public function quiz_question()
    {
        return view('admin.quiz.question', [
            'page' => 'Quiz'
        ]);
    }
    public function quiz_result(){
        return view('admin.quiz.quiz_result', [
            'page' => 'Quiz'
        ]);
    }

    // CATEGORY

    public function category(){
        $category = Category::latest()->get();
        return view('admin.category.category', [
            'data' => $category,
            'page' => 'Category'
        ]);
    }

    // EDUCATION
    public function education(){
        $education = Education::latest()->get();
        return view('admin.education.education', [
            'data' => $education,
            'page' => 'Education'
        ]);
    }

    // INDEX

    public function index(){
        return view('user.index', [
            'page' => 'Home'
        ]);
    }

    public function user_quiz(){
        return view('user.quiz-user', [
            'page' => 'Quiz'
        ]);
    }

    public function user_score(){
        return view('user.score', [
            'page' => 'Score'
        ]);
    }

    public function user_quiz_page(){
        return view('user.quiz_page', [
            'page' => 'Quiz'
        ]);
    }
}
