<?php

namespace App\Http\Controllers;

use App\Models\Choice;
use App\Models\Education;
use App\Models\Question;
use App\Models\Quiz;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

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
    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // Validate the request data
        $validatedData = $request->validate([
            'quiz_id' => 'required|exists:quizzes,id', // Ensure quiz_id is provided and exists in quizzes table
            'question' => 'required|string',
            'choices' => 'required|array',
            'choices.*' => 'string',
            'is_correct' => 'required|array',
            'point_value' => 'required',
            'question_type' => 'required',
            'questionImage' => 'nullable|image', // Add validation for question image
            'choice_images.*' => 'nullable|image', // Validation for choice images
        ]);

        // Handle question image upload
        if ($request->hasFile('questionImage')) {
            $imagePath = $request->file('questionImage')->store('question_images', 'public');
            $imageUrl = asset('storage/' . $imagePath);
        } else {
            $imageUrl = null;
        }

        // Get the currently authenticated user
        $user = Auth::user();
        $lastQuestionNumber = Question::where('quiz_id', $validatedData['quiz_id'])->max('number') ?? 0;

        // Create a new question instance
        $question = new Question();
        $question->question = $validatedData['question'];
        $question->point_value = $validatedData['point_value'];
        $question->question_type = $validatedData['question_type'];
        $question->quiz_id = $validatedData['quiz_id']; // Assign quiz_id from validated data
        $question->created_by = $user->id;
        $question->updated_by = $user->id;
        $question->number = $lastQuestionNumber + 1;
        $question->images = $imageUrl; // Save the question image URL
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

            // Handle choice image upload
            if ($request->hasFile('choice_images.' . $index)) {
                $imagePath = $request->file('choice_images.' . $index)->store('choice_images', 'public');
                $questionChoice->image_choice = $imagePath;
            }

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
            'essayImage' => 'nullable|image', // Add validation for essay image
        ]);

        // Get the currently authenticated user
        $user = Auth::user();
        $lastQuestionNumber = Question::where('quiz_id', $request->quiz_id)->max('number') ?? 0;

        // Handle essay image upload
        if ($request->hasFile('essayImage')) {
            $imagePath = $request->file('essayImage')->store('essay_images', 'public');
            $imageUrl = asset('storage/' . $imagePath);
        } else {
            $imageUrl = null;
        }

        // Create the essay question
        $question = new Question();
        $question->quiz_id = $validatedData['quiz_id'];
        $question->point_value = 0; // Default value for essays
        $question->question = $validatedData['question'];
        $question->question_type = $validatedData['question_type'];
        $question->created_by = $user->id;
        $question->updated_by = $user->id;
        $question->number = $lastQuestionNumber + 1;
        $question->images = $imageUrl; // Save the essay image URL
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
            'question_type' => 'required|string',
            'quiz_id' => 'required|exists:quizzes,id',
            'question' => 'required|string',
            'choices' => 'required|array',
            'choices.*' => 'string',
            'point_value' => 'required|array',
            'point_value.*' => 'numeric|min:0',
            'choice_images.*' => 'nullable|image', // Validation for choice images
        ]);

        // Get the currently authenticated user
        $user = Auth::user();
        $lastQuestionNumber = Question::where('quiz_id', $request->quiz_id)->max('number') ?? 0;

        // Handle question image upload
        if ($request->hasFile('weightedEssayImage')) {
            $imagePath = $request->file('weightedEssayImage')->store('weighted_essay_images', 'public');
            $imageUrl = asset('storage/' . $imagePath);
        } else {
            $imageUrl = null;
        }

        // Create the question
        $question = Question::create([
            'quiz_id' => $validatedData['quiz_id'],
            'point_value' => 0,
            'question' => $validatedData['question'],
            'question_type' => $validatedData['question_type'],
            'created_by' => $user->id,
            'updated_by' => $user->id,
            'number' => $lastQuestionNumber + 1,
            'images' => $imageUrl, // Save the image URL
        ]);

        // Attach choices to the question
        foreach ($validatedData['choices'] as $index => $choice) {
            $questionChoice = $question->choices()->create([
                'choice' => $choice,
                'is_correct' => false, // Adjust as necessary
                'point_value' => $validatedData['point_value'][$index],
                'created_by' => $user->id,
                'updated_by' => $user->id,
            ]);

            // Handle choice image upload
            if ($request->hasFile('choice_images.' . $index)) {
                // Upload and save choice image
                $imagePath = $request->file('choice_images.' . $index)->store('choice_images', 'public');
                $questionChoice->image_choice = $imagePath;
                $questionChoice->save();
            }
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
        $lastQuestionNumber = Question::max('number') ?? 0;
        // Load the view and pass the quiz data to it
        return view('admin.quiz.question', [
            'page' => $quiz->title,
            'lastQuestionNumber' => $lastQuestionNumber,
        ], compact('quiz', 'questions'));
    }

    /**
     * Update the specified resource in storage.
     */
    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $validatedData = $request->validate([
            'quiz_id' => 'required', // Assuming quiz_id cannot be changed
            'question' => 'required|string',
            'point_value' => 'required',
            'question_type' => 'required',
            'questionImage' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048', // Add validation for question image
            'choices' => 'required|array',
            'choices.*' => 'string',
            'is_correct' => 'required|array',
            'choice_images.*' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048', // Validation for choice images
        ]);

        // Get the authenticated user
        $updatedBy = Auth::user()->id;

        // Find the question by ID
        $question = Question::findOrFail($id);

        // Handle question image update
        if ($request->hasFile('questionImage')) {
            // Delete the old question image if it exists
            if ($question->images) {
                Storage::disk('public')->delete($question->images);
            }
            // Store the new question image
            $imagePath = $request->file('questionImage')->store('question_images', 'public');
            $question->images = $imagePath;
        }

        // Update question details
        $question->update([
            'question' => $validatedData['question'],
            'point_value' => $validatedData['point_value'],
            'question_type' => $validatedData['question_type'],
            'updated_by' => $updatedBy,
        ]);

        // Update or create choices associated with the question
        $choicesCount = count($validatedData['choices']);
        for ($index = 0; $index < $choicesCount; $index++) {
            // Get the choice ID from the request, if available
            $choiceId = $request->input('choice_ids.' . $index);
            $questionChoice = null;

            // If a choice ID is provided, find the existing choice
            if ($choiceId) {
                $questionChoice = Choice::find($choiceId);
            }

            // If no existing choice found, or if the choice ID doesn't match the index, create a new one
            if (!$questionChoice || $questionChoice->id != $choiceId) {
                $questionChoice = new Choice();
            }

            // Update choice details
            $questionChoice->question_id = $question->id;
            $questionChoice->choice = $validatedData['choices'][$index];
            $questionChoice->is_correct = isset($validatedData['is_correct'][$index]);
            $questionChoice->created_by = $updatedBy;
            $questionChoice->updated_by = $updatedBy;

            // Handle choice image update
            if ($request->hasFile('choice_images.' . $index)) {
                // Delete the old choice image if it exists
                if ($questionChoice->image_choice) {
                    Storage::disk('public')->delete($questionChoice->image_choice);
                }
                // Store the new choice image
                $imagePath = $request->file('choice_images.' . $index)->store('choice_images', 'public');
                $questionChoice->image_choice = $imagePath;
            }

            $questionChoice->save();
        }

        return redirect()->back()->with('success', 'Question updated successfully!');
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
