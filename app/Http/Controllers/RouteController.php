<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Education;
use App\Models\Question;
use App\Models\Quiz;
use App\Models\User;
use App\Models\Choice;
use App\Models\UserScore;
use App\Models\UserAnswer;
use App\Models\UserEssay;
use Illuminate\Http\Request;

class RouteController extends Controller
{
    public function admin_dashboard()
    {
        $data = Quiz::latest()->get();
        $category = Category::latest()->get();
        $education = Education::latest()->get();
        $user = User::latest()->get();
        $scores = UserScore::all();
        return view('admin.dashboard', [
            'page' => 'Dashboard',
            'category' => $category,
            'education' => $education,
            'data' => $data,
            'user' => $user,
            'scores' => $scores
        ]);
    }

    public function admin_profile()
    {
        return view('admin.edit-profile', [
            'page' => 'Profile'
        ]);
    }

    // QUIZ

    public function quiz()
    {
        $category = Category::latest()->get();
        $education = Education::latest()->get();
        $quiz = Quiz::latest()->get();
        $user = User::latest()->get();
        $scores = UserScore::all();
        return view('admin.quiz.quiz', [
            'page' => 'Quiz',
            'category' => $category,
            'education' => $education,
            'data' => $quiz,
            'user' => $user,
            'scores' => $scores
        ]);
    }

    public function quiz_result()
    {
        return view('admin.quiz.quiz_result', [
            'page' => 'Quiz'
        ]);
    }


    public function quiz_review()
    {
        return view('admin.quiz.review', [
            'page' => 'Quiz'
        ]);
    }

    // ADMIN USERS

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

    // CATEGORY

    public function category()
    {
        $category = Category::latest()->get();
        return view('admin.category.category', [
            'data' => $category,
            'page' => 'Category'
        ]);
    }

    // EDUCATION
    public function education()
    {
        $education = Education::latest()->get();
        return view('admin.education.education', [
            'data' => $education,
            'page' => 'Education'
        ]);
    }

    // INDEX


    public function index()
    {
        $data = Quiz::latest()->get();
        $category = Category::latest()->get();
        $education = Education::latest()->get();
        $choice = Choice::all();
        $scores = UserScore::all();
        $answers = UserAnswer::all();
        $essays = UserEssay::all();

        return view('views.index', [
            'category' => $category,
            'education' => $education,
            'data' => $data,
            'choice' => $choice,
            'scores' => $scores,
            'answers' => $answers,
            'essays' => $essays,
            'page' => 'Home'
        ]);
    }

    public function user_quiz()
    {
        $data = Quiz::latest()->get();
        $category = Category::latest()->get();
        $education = Education::latest()->get();
        $choice = Choice::all();
        $scores = UserScore::all();
        $answers = UserAnswer::all();
        $essays = UserEssay::all();

        return view('views.quiz_user', [
            'category' => $category,
            'education' => $education,
            'data' => $data,
            'choice' => $choice,
            'scores' => $scores,
            'answers' => $answers,
            'essays' => $essays,
            'page' => 'Quiz'
        ]);
    }


    public function user_score()
    {
        $data = Quiz::latest()->get();
        $category = Category::latest()->get();
        $education = Education::latest()->get();
        $choice = Choice::all();
        $scores = UserScore::all();
        $answers = UserAnswer::all();
        $essays = UserEssay::all();

        return view('views.score', [
            'category' => $category,
            'education' => $education,
            'data' => $data,
            'choice' => $choice,
            'scores' => $scores,
            'answers' => $answers,
            'essays' => $essays,
            'page' => 'Score'
        ]);
    }

    public function user_quiz_page($slug)
    {
        $data = Quiz::where('slug', $slug)->first();
        return view('views.quiz_page', [
            'page' => 'Quiz',
            'data' => $data,
        ]);
    }
}
