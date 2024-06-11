<?php

namespace App\Http\Controllers;

use App\Models\Quiz;
use App\Models\UserAnswer;
use App\Models\UserEssay;
use App\Models\Question;
use App\Models\Category;
use App\Models\Education;
use App\Models\User;
use App\Models\UserScore;
use App\Models\Choice;
use App\Models\QuizResult;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;

class QuizController extends Controller
{
    public function index(Request $request)
    {
        $category = Category::all();
        $education = Education::all();

        $query = Quiz::query();

        if ($request->has('category') && $request->category != '') {
            $query->where('category_id', $request->category);
        }

        if ($request->has('education') && $request->education != '') {
            $query->where('education_id', $request->education);
        }

        $data = $query->get();

        return view('views\quiz_user', compact('data', 'category', 'education'));
    }

    public function quizSearch(Request $request)
    {
        $query = Quiz::query();

        if ($request->has('table_search')) {
            $search = $request->input('table_search');
            $query->where('title', 'like', '%' . $search . '%');
        }

        $quizzes = $query->get();
        $category = Category::all();
        $education = Education::all();
        $users = $query->get();

        return view('admin/quiz/quiz', [
            'page' => 'Quiz',
            'category' => $category,
            'education' => $education,
            'data' => $quizzes,
            'user' => $users
        ]);
    }

    public function adminIndex(Request $request)
    {
        $category = Category::all();
        $education = Education::all();

        $query = Quiz::query();

        if ($request->has('category') && $request->category != '') {
            $query->where('category_id', $request->category);
        }

        if ($request->has('education') && $request->education != '') {
            $query->where('education_id', $request->education);
        }

        $data = $query->get();
        $user = User::latest()->get(); // Fetching the latest users

        $page = 'Dashboard'; // Define the $page variable

        return view('admin.dashboard', compact('data', 'category', 'education', 'user', 'page'));
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
            'slug' => 'unique:quizzes',
            'thumbnail' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048', // Add validation for thumbnail
        ]);

        $created_by = Auth::user()->id;
        $updated_by = Auth::user()->id;
        $slug = Str::slug($request->title);

        // Store the thumbnail file if it exists
        $thumbnailPath = null;
        if ($request->hasFile('thumbnail')) {
            $thumbnailPath = $request
                ->file('thumbnail')
                ->store('thumbnails', 'public');
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
            'updated_by' => $updated_by,
        ]);

        // Calculate max_score
        $quiz->calculateMaxScore();

        return redirect('/admin/quiz')->with(
            'quiz_success',
            'Quiz Add Success!'
        );
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
            'thumbnail' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048', // Add validation for thumbnail
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
            $thumbnailPath = $request
                ->file('thumbnail')
                ->store('thumbnails', 'public');
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
            'updated_by' => $updated_by,
        ]);

        // Calculate max_score
        $quiz->calculateMaxScore();

        return redirect('/admin/quiz')->with(
            'success',
            'Quiz Updated Successfully!'
        );
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

        return redirect()
            ->back()
            ->with('success', 'Quiz deleted successfully!');
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

        // Load user's essay answers for the questions
        $userEssays = UserEssay::where('user_id', Auth::id())
            ->whereIn('question_id', $questions->pluck('id'))
            ->get();

        // Get the countdown time from the quiz
        $countdownTime = $quiz->time;
        $data = Quiz::where('slug', $slug)->first();
        return view('views.quiz_page', [
            'page' => $quiz->title,
            'quiz' => $quiz,
            'questions' => $questions,
            'lastQuestionNumber' => $lastQuestionNumber,
            'slug' => $quiz->slug,
            'question_number' => 1,
            'userAnswers' => $userAnswers,
            'userEssays' => $userEssays, // Pass user's essay answers to the view
            'countdownTime' => $quiz->time,
            'data' => $data,
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

        // Load user's essay answers for the questions
        $userEssays = UserEssay::where('user_id', Auth::id())
            ->whereIn('question_id', $questions->pluck('id'))
            ->get();

        $data = Quiz::where('slug', $slug)->first();
        return view(
            'views.quiz_page',
            [
                'page' => $quiz->title,
                'quiz' => $quiz,
                'questions' => $questions,
                'lastQuestionNumber' => $lastQuestionNumber,
                'slug' => $quiz->slug,
                'question_number' => $number,
                'userAnswers' => $userAnswers, // Pass user's answers to the view
                'userEssays' => $userEssays, // Pass user's essay answers to the view
                'data' => $data,
            ]
        );
    }

    public function submitQuiz(Request $request)
    {
        $userId = Auth::id();
        $quizId = $request->input('quiz_id');

        // Get the IDs of the questions belonging to the quiz
        $quizQuestionIds = Question::where('quiz_id', $quizId)->pluck('id');

        // Calculate the total score based on user's answers for the quiz questions
        $userAnswers = UserAnswer::where('user_id', $userId)
            ->whereIn('question_id', $quizQuestionIds)
            ->get();

        $totalScore = 0;

        foreach ($userAnswers as $answer) {
            $choice = Choice::find($answer->choosen_choice_id);
            if ($choice) {
                $totalScore += $choice->score; // Assuming 'score' column exists in 'choices' table
            }
        }

        // Save or update the total score in the user_score table
        UserScore::updateOrCreate(
            ['user_id' => $userId, 'quiz_id' => $quizId],
            ['score' => $totalScore]
        );

        // Redirect to a confirmation page or quiz results
        return redirect('/home');
    }

    // public function reviewPage()
    // {
    //     // Getting user answers from the database (for example by using Eloquent or Query Builder)
    //     $userAnswer = UserAnswer::find(1);

    //     // Get related questions with user answers
    //     $question = $userAnswer->question;

    //     // get answer options related to the question
    //     $options = $question->options;

    //     // Send data to view review
    //     return view('review.page', [
    //         'userAnswer' => $userAnswer,
    //         'question' => $question,
    //         'options' => $options,
    //     ]);
    // }

    public function quizReviewIndex()
    {
        $quizResults = QuizResult::with('user')->get();
        dd($quizResults);
        return view('quiz', compact('quizResults'));
    }
}
