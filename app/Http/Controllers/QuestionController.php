<?php

namespace App\Http\Controllers;

use App\Models\Choice;
use App\Models\Education;
use App\Models\Question;
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
            'is_correct' => 'required|array', // Validate the is_correct field
            'point_value' => 'required',
            'question_type' => 'required'
        ]);

        // Get the currently authenticated user
        $user = Auth::user();

        // Create a new question instance
        $question = new Question();
        $question->question = $validatedData['question'];
        $question->point_value = $validatedData['point_value'];
        $question->question_type = $validatedData['question_type'];
        $question->quiz_id = $request->quiz_id;
        $question->created_by = $user->id;
        $question->updated_by = $user->id;
        // Additional attributes of the question can be set here
        $question->save();

        // Save the choices associated with the question
        foreach ($validatedData['choices'] as $index => $choice) {
            $questionChoice = new Choice();
            $questionChoice->question_id = $question->id;
            $questionChoice->choice = $choice;
            // Check if the current choice is marked as correct
            $questionChoice->is_correct = isset($validatedData['is_correct'][$index]);
            $questionChoice->created_by = $user->id;
            $questionChoice->updated_by = $user->id;
            $questionChoice->save();
        }
        return redirect()->back()->with('success', 'Question created successfully!');
    }

    /**
     * Store a newly created essay question in storage.
     */
    public function essayStore(Request $request)
    {
        // Validate the request data
        $validatedData = $request->validate([
            'question_type' => 'required|string',
            'quiz_id' => 'required|exists:quizzes,id',
            'question' => 'required|string',
        ]);

        // Get the currently authenticated user
        $user = Auth::user();

        // Create the essay question
        $question = new Question();
        $question->quiz_id = $validatedData['quiz_id'];
        $question->point_value = 0; // Default value for essays
        $question->question = $validatedData['question'];
        $question->question_type = $validatedData['question_type'];
        $question->created_by = $user->id;
        $question->updated_by = $user->id;
        $question->save();

        // Redirect back or return a response
        return redirect()->back()->with('success', 'Essay question created successfully!');
    }

    /**
     * Store a newly created weighted multiple choice question in storage.
     */
    public function weightedStore(Request $request)
    {
        // Validate the form data
        $validatedData = $request->validate([
            'question_type' => 'required|string', // Ensure that 'question_type' is present and a string
            'quiz_id' => 'required|exists:quizzes,id', // Ensure that 'quiz_id' exists in the 'quizzes' table
            'question' => 'required|string',
            'choices' => 'required|array',
            'choices.*' => 'string',
            'point_value' => 'required|array',
            'point_value.*' => 'numeric|min:0', // Ensure that each 'points' value is numeric and greater than or equal to 0
        ]);

        $created_by = Auth::user()->id;

        // Create the question
        $question = Question::create([
            'quiz_id' => $validatedData['quiz_id'],
            'point_value' => '0',
            'question' => $validatedData['question'],
            'question_type' => $validatedData['question_type'],
            'created_by' => $created_by,
            'updated_by' => $created_by
        ]);

        // Attach choices to the question
        foreach ($validatedData['choices'] as $index => $choice) {
            $question->choices()->create([
                'choice' => $choice,
                'is_correct' => $request->has('is_correct') && $request->input('is_correct') == $index,
                'point_value' => $validatedData['point_value'][$index],
                'created_by' => $created_by,
                'updated_by' => $created_by
            ]);
        }

        // Redirect back or return a response
        return redirect()->back()->with('success', 'Question created successfully!');
    }

    /**
     * Display the specified resource.
     */
    public function show($slug)
    {
        // Find the quiz by slug
        $quiz = Quiz::where('slug', $slug)->first();
        $questions = $quiz->questions;
        // If quiz is not found, return a response (you can modify this as per your requirement)
        if (!$quiz) {
            return response()->json(['message' => 'Quiz not found'], 404);
        }

        // Load the view and pass the quiz data to it
        return view('admin.quiz.question', [
            'page' => $quiz->title,
        ], compact('quiz', 'questions'));
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
    public function destroy(string $id)
    {
        $question = Question::where('id', $id);
        $question->delete();

        return redirect()->back()->with('success', 'Question deleted successfully!');
    }
}
