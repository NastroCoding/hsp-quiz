<?php

namespace App\Http\Controllers;

use App\Models\Choice;
use App\Models\Question;
use App\Models\Quiz;
use App\Models\UserAnswer;
use App\Models\UserEssay;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class UserAnswerController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index($quiz_id)
    {
        $questions = Question::where('quiz_id', $quiz_id)->get();
        $rightAnswerCount = 0;
        foreach ($questions as $question) {
            $userAnswers = UserAnswer::where('question_id', $question->id)->get();

            foreach ($userAnswers as $userAnswer) {
                $choice = Choice::find($userAnswer->choosen_choice_id);
                
                if ($choice && $choice->is_correct) {
                    $rightAnswerCount += $question->point_value;
                }
            }
        }

        return $rightAnswerCount . '/';
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // Validate the request data
        $validatedData = $request->validate([
            'question_id' => 'required|exists:questions,id',
            'choosen_choice_id' => 'required|exists:choices,id',
        ]);

        // Get the chosen choice
        $chosenChoice = Choice::findOrFail($validatedData['choosen_choice_id']);

        // Determine if the chosen choice is correct
        $isCorrect = $chosenChoice->is_correct;

        // Add the authenticated user's ID and is_correct to the data
        $validatedData['user_id'] = Auth::id();
        $validatedData['is_correct'] = $isCorrect;

        // Set the created_by and updated_by fields to the authenticated user's ID
        $validatedData['created_by'] = Auth::id();
        $validatedData['updated_by'] = Auth::id();

        // Check if the user has already answered this question
        $existingAnswer = UserAnswer::where('user_id', Auth::id())
            ->where('question_id', $validatedData['question_id'])
            ->first();

        // If an existing answer is found, update it; otherwise, create a new one
        if ($existingAnswer) {
            $existingAnswer->update([
                'choosen_choice_id' => $validatedData['choosen_choice_id'],
                'is_correct' => $isCorrect,
                'updated_by' => Auth::id(),
            ]);
            $message = 'Your answer has been updated successfully!';
        } else {
            UserAnswer::create($validatedData);
            $message = 'Your answer has been submitted successfully!';
        }

        return redirect('/quiz')->with('success', $message);
    }

    /**
     * Store a newly created essay answer in storage.
     */
    public function storeEssayAnswer(Request $request)
    {
        // Validate the request data
        $validatedData = $request->validate([
            'question_id' => 'required|exists:questions,id',
            'essay_answer' => 'required|string',
        ]);

        // Add the authenticated user's ID to the data
        $validatedData['user_id'] = Auth::id();

        // Set the created_by and updated_by fields to the authenticated user's ID
        $validatedData['created_by'] = Auth::id();
        $validatedData['updated_by'] = Auth::id();

        try {
            // Check if the user has already answered this question
            $existingAnswer = UserEssay::where('user_id', Auth::id())
                ->where('question_id', $validatedData['question_id'])
                ->first();

            // If an existing answer is found, update it; otherwise, create a new one
            if ($existingAnswer) {
                $existingAnswer->update([
                    'answer' => $validatedData['essay_answer'],
                    'updated_by' => Auth::id(),
                ]);
                $message = 'Your essay answer has been updated successfully!';
            } else {
                UserEssay::create([
                    'user_id' => $validatedData['user_id'],
                    'question_id' => $validatedData['question_id'],
                    'answer' => $validatedData['essay_answer'],
                    'created_by' => $validatedData['created_by'],
                    'updated_by' => $validatedData['updated_by'],
                ]);
                $message = 'Your essay answer has been submitted successfully!';
            }

            return redirect('/quiz')->with('success', $message);
        } catch (\Exception $e) {
            // Log the error
            Log::error('Error storing essay answer: ' . $e->getMessage(), $validatedData);

            // Return with error message
            return redirect('/quiz')->with('error', 'There was a problem submitting your answer. Please try again.');
        }
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        // Fetch the essay answer by id
        $essay = UserEssay::findOrFail($id);

        // Pass the essay answer to the view
        return view('essay.show', ['essay_answer' => $essay->answer]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, UserAnswer $userAnswer)
    {
        // Code for updating a resource (if needed)
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(UserAnswer $userAnswer)
    {
        // Code for deleting a resource (if needed)
    }
}
