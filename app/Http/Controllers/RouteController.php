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
        return view('admin.add_quiz', [
            "active" => "active",
            "page" => "Quiz"
        ]);
    }

    public function users()
    {
        return view('admin.users', [
            "active" => "active",
            "page" => "Users"
        ]);
    }
}
