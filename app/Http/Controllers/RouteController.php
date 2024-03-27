<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class RouteController extends Controller
{
    public function admin_dashboard()
    {
        return view('admin.dashboard', ["page" => "Dashboard"]);
    }

    public function add_quiz()
    {
        return view('admin.quiz.add_quiz', [
            "active" => "active",
            "page" => "Quiz"
        ]);
    }
    public function quiz_question()
    {
        return view('admin.quiz.add_quest&ans', [
            "active" => "active",
            "page" => "Quiz"
        ]);
    }

    public function quiz_result(){
        return view('admin.quiz.quiz_result', [
            "active" => "active",
            "page" => "Quiz"
        ]);
    }

    public function users()
    {
        return view('admin.user.users', [
            "active" => "active",
            "page" => "Users"
        ]);
    }
}
