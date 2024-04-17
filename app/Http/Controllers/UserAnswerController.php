<?php

namespace App\Http\Controllers;

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

        // Add the authenticated user's ID to the data
        $validatedData['user_id'] = Auth::id();

        // Set the created_by and updated_by fields to the authenticated user's ID
        $validatedData['created_by'] = Auth::id();
        $validatedData['updated_by'] = Auth::id();

        // Create a new UserAnswer instance and save it to the database
        UserAnswer::create($validatedData);

        return redirect('/quiz')->with('success', 'Your answers have been submitted successfully!');
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
