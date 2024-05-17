<?php

namespace App\Http\Controllers;

use App\Models\Choice;
use App\Models\UserAnswer;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class UserAnswerController extends Controller
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
            $message = 'Your answers have been submitted successfully!';
        }

        return redirect('/quiz')->with('success', $message);
    }

    /**
     * Display the specified resource.
     */
    public function show(UserAnswer $userAnswer)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, UserAnswer $userAnswer)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(UserAnswer $userAnswer)
    {
        //
    }
}
