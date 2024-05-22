<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\UserAnswer;
use Illuminate\Support\Facades\Auth;

class ReviewController extends Controller
{
    public function show($id)
    {
        $quiz = Quiz::with(['questions.options', 'user'])->findOrFail($id);
        return view('admin.review', compact('quiz'));
    }
}
