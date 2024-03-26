<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class RouteController extends Controller
{
    public function admin_dashboard(){
        return view('admin.dashboard');
    }

    public function add_quiz(){
        return view('admin.add_quiz');
    }

    public function users(){
        return view('admin.users');
    }

}
