<?php

namespace App\Http\Controllers;

use App\Models\Choice;
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
        // Validate the request data
        $validatedData = $request->validate([
            'question' => 'required|string',
            'choices' => 'required|array',
            'choices.*' => 'string',
            'point_value' => 'required'
        ]);

        // Get the currently authenticated user
        $user = Auth::user();

        // Create a new question instance
        $question = new Question();
        $question->question = $validatedData['question'];
        $question->point_value = $validatedData['point_value'];
        $question->quiz_id = $request->quiz_id;
        $question->created_by = $user->id;
        $question->updated_by = $user->id;
        // Additional attributes of the question can be set here
        $question->save();

        // Save the choices associated with the question
        foreach ($validatedData['choices'] as $choice) {
            $questionChoice = new Choice();
            $questionChoice->question_id = $question->id;
            $questionChoice->choice = $choice;
            $questionChoice->created_by = $user->id;
            $questionChoice->updated_by = $user->id;
            // Additional attributes of the choice can be set here
            $questionChoice->save();
        }
        return redirect()->back()->with('success', 'Question created successfully!');
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
        ], compact('quiz'));
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
