<?php

namespace App\Http\Controllers;

use App\Models\Question;
use App\Models\Quiz;
use App\Models\UserAnswer;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Auth;

class QuizController extends Controller
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
        $validate = $request->validate([
            'category_id' => 'required',
            'education_id' => 'required',
            'token' => 'required',
            'title' => 'required',
            'description' => 'required',
            'time' => 'required',
            'slug' => 'unique'
        ]);

        $created_by = Auth::user()->id;
        $updated_by = Auth::user()->id;
        $slug = Str::slug($request->title);

        $quiz = Quiz::create([
            'category_id' => $request->category_id,
            'education_id' => $request->education_id,
            'token' => $request->token,
            'title' => $request->title,
            'description' => $request->description,
            'time' => $request->time,
            'slug' => $slug,
            'created_by' => $created_by,
            'updated_by' => $updated_by
        ]);

        return redirect('/admin/quiz')->with('quiz_success', 'Quiz Add Success!');
    }

    /**
     * Display the specified resource.
     */
    public function quiz_view(Request $request, string $slug)
    {
        $validate = $request->validate([
            'token' => 'required',
        ]);

        $quiz = Quiz::where('slug', $slug)->first();

        if (!$quiz) {
            return redirect('/quiz')->with('failed', 'Quiz not found!');
        }

        if ($request->token != $quiz->token) {
            return redirect('/quiz')->with('failed', 'Invalid token!');
        }

        // Load questions associated with the quiz
        $questions = $quiz->questions;
        $lastQuestionNumber = Question::where('quiz_id', $quiz->id)->max('number') ?? 0;

        $userAnswers = UserAnswer::where('user_id', Auth::id())
            ->whereIn('question_id', $questions->pluck('id'))
            ->get();

        // Pass userAnswers to the view
        return view('views.quiz_page', [
            'page' => $quiz->title,
            'quiz' => $quiz,
            'questions' => $questions,
            'lastQuestionNumber' => $lastQuestionNumber,
            'slug' => $quiz->slug,
            'question_number' => 1,
            'userAnswers' => $userAnswers, // Pass user's answers to the view
        ]);
    }

    public function quiz_num($slug, $number)
    {
        $quiz = Quiz::where('slug', $slug)->first();
        if (!$quiz) {
            // Handle case where quiz is not found
            return response()->json(['message' => 'Quiz not found'], 404);
        }

        $question = Question::where('quiz_id', $quiz->id)
            ->where('number', $number)
            ->first();

            $questions = $quiz->questions;
            $lastQuestionNumber = Question::where('quiz_id', $quiz->id)->max('number') ?? 0;

        if (!$question) {
            // Handle case where question is not found
            return response()->json(['message' => 'Question not found'], 404);
        }

        $userAnswers = UserAnswer::where('user_id', Auth::id())
            ->whereIn('question_id', $questions->pluck('id'))
            ->get();

        // Pass userAnswers to the view
        return view('views.quiz_page', [
            'page' => $quiz->title,
            'quiz' => $quiz,
            'questions' => $questions,
            'lastQuestionNumber' => $lastQuestionNumber,
            'slug' => $quiz->slug,
            'question_number' => $number,
            'userAnswers' => $userAnswers, // Pass user's answers to the view
        ], compact('question'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $validate = $request->validate([
            'category_id' => 'required',
            'education_id' => 'required',
            'token' => 'required',
            'title' => 'required',
            'description' => 'required',
            'time' => 'required',
        ]);

        $updated_by = Auth::user()->id;
        $slug = Str::slug($request->title);

        $quiz = Quiz::where('id', $id);

        $quiz->update([
            'category_id' => $request->category_id,
            'education_id' => $request->education_id,
            'token' => $request->token,
            'title' => $request->title,
            'description' => $request->description,
            'time' => $request->time,
            'slug' => $slug,
            'updated_by' => $updated_by
        ]);

        return redirect('/admin/quiz')->with('success', 'Quiz Updated Successfully!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $quiz = Quiz::where('id', $id);
        $quiz->delete();

        return redirect()->back()->with('success', 'Quiz deleted successfully!');
    }
}
