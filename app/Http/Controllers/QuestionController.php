<?php

namespace App\Http\Controllers;

use App\Models\Question;
use App\Models\Question_Choice;
use App\Models\Quiz;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class QuestionController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
    // Validate input
    $validatedData = $request->validate([
        'question' => 'required|string',
        'choices' => 'required|array',
        'choices.*' => 'required|string',
    ]);

    // Create the question
    $question = Question::create([
        'question' => $validatedData['question'],
        'quiz_id' => $request->quiz_id,
        'created_by' => Auth::user()->id,
        'updated_by' => Auth::user()->id,
    ]);
    // Create choices for the question
    foreach ($validatedData['choices'] as $choiceText) {
        Question_Choice::create([
            'quiz_id' => $request->quiz_id,
            'question_id' => $question->id,
            'choice' => $choiceText,
            'created_by' => Auth::user()->id,
            'updated_by' => Auth::user()->id,
        ]);
    }
    return redirect('/admin/quiz/question')->with('success', 'Question created successfully!');

    }

    /**
     * Display the specified resource.
     */
    public function show($slug)
    {
        // Find the quiz by slug
        $quiz = Quiz::where('slug', $slug)->first();

        // If quiz is not found, return a response (you can modify this as per your requirement)
        if (!$quiz) {
            return response()->json(['message' => 'Quiz not found'], 404);
        }

        // Load the view and pass the quiz data to it
        return view('admin.quiz.question', [
            'page' => $slug,
        ] ,compact('quiz'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Question $question)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Question $question)
    {
        //
    }
}
