<?php

namespace App\Http\Controllers;

use App\Models\Quiz;
use App\Models\UserAnswer;
use App\Models\Question;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class QuizController extends Controller
{
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
            'slug' => 'unique:quizzes',
            'thumbnail' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048' // Add validation for thumbnail
        ]);

        $created_by = Auth::user()->id;
        $updated_by = Auth::user()->id;
        $slug = Str::slug($request->title);

        // Store the thumbnail file if it exists
        $thumbnailPath = null;
        if ($request->hasFile('thumbnail')) {
            $thumbnailPath = $request->file('thumbnail')->store('thumbnails', 'public');
        }

        $quiz = Quiz::create([
            'category_id' => $request->category_id,
            'education_id' => $request->education_id,
            'token' => $request->token,
            'title' => $request->title,
            'description' => $request->description,
            'time' => $request->time,
            'slug' => $slug,
            'thumbnail' => $thumbnailPath, // Store the thumbnail path
            'created_by' => $created_by,
            'updated_by' => $updated_by
        ]);

        return redirect('/admin/quiz')->with('quiz_success', 'Quiz Add Success!');
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
            'thumbnail' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048' // Add validation for thumbnail
        ]);

        $updated_by = Auth::user()->id;
        $slug = Str::slug($request->title);

        $quiz = Quiz::findOrFail($id);

        // Update the thumbnail path if a new thumbnail is provided
        if ($request->hasFile('thumbnail')) {
            // Delete the old thumbnail if it exists
            if ($quiz->thumbnail) {
                Storage::disk('public')->delete($quiz->thumbnail);
            }
            // Store the new thumbnail
            $thumbnailPath = $request->file('thumbnail')->store('thumbnails', 'public');
            $quiz->thumbnail = $thumbnailPath;
        }

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
        $quiz = Quiz::findOrFail($id);
        // Delete the associated thumbnail if it exists
        if ($quiz->thumbnail) {
            Storage::disk('public')->delete($quiz->thumbnail);
        }
        $quiz->delete();

        return redirect()->back()->with('success', 'Quiz deleted successfully!');
    }

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
        $lastQuestionNumber = $questions->max('number') ?? 0;

        $userAnswers = UserAnswer::where('user_id', Auth::id())
            ->whereIn('question_id', $questions->pluck('id'))
            ->get();

        // Get the countdown time from the quiz
        $countdownTime = $quiz->time;

        return view('views.quiz_page', [
            'page' => $quiz->title,
            'quiz' => $quiz,
            'questions' => $questions,
            'lastQuestionNumber' => $lastQuestionNumber,
            'slug' => $quiz->slug,
            'question_number' => 1,
            'userAnswers' => $userAnswers, // Pass user's answers to the view
            'countdownTime' => $quiz->time, // Pass the countdown time to the view
        ]);
    }

    public function quiz_num($slug, $number)
    {
        $quiz = Quiz::where('slug', $slug)->first();
        if (!$quiz) {
            return response()->json(['message' => 'Quiz not found'], 404);
        }

        $question = Question::where('quiz_id', $quiz->id)
            ->where('number', $number)
            ->first();

        $questions = $quiz->questions;
        $lastQuestionNumber = $questions->max('number') ?? 0;

        if (!$question) {
            return response()->json(['message' => 'Question not found'], 404);
        }

        $userAnswers = UserAnswer::where('user_id', Auth::id())
            ->whereIn('question_id', $questions->pluck('id'))
            ->get();

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
}
