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
    public function store(Request $request)
    {
        // Validate the request data
        $validatedData = $request->validate([
            'quiz_id' => 'required|exists:quizzes,id', // Ensure quiz_id is provided and exists in quizzes table
            'question' => 'required|string',
            'point_value' => 'required|numeric', // Ensure point_value is numeric
            'question_type' => 'required|string',
            'questionImage' => 'nullable|image', // Add validation for question image
            'choices' => 'required_without:choice_images|array',
            'choices.*' => 'required_without:choice_images.*', // Require string for each choice if choice_images are not provided
            'is_correct' => 'required|array', // Make is_correct field required
            'is_correct.*' => 'required|boolean', // Make each is_correct value a boolean
            'choice_images' => 'required_without:choices|array',
            'choice_images.*' => 'required_without:choices.*|image', // Validation for choice images
        ]);

        // Ensure that the number of is_correct values matches the number of choices
        if (count($validatedData['choices']) !== count($validatedData['is_correct'])) {
            return redirect()->back()->withErrors(['is_correct' => 'The number of is_correct values must match the number of choices.'])->withInput();
        }

        // Check if at least one choice is marked as correct
        if (!in_array(true, $validatedData['is_correct'])) {
            return redirect()->back()->withErrors(['is_correct' => 'At least one choice must be marked as correct.'])->withInput();
        }

        // Handle question image upload
        $imageUrl = null;
        if ($request->hasFile('questionImage')) {
            $imagePath = $request->file('questionImage')->store('question_images', 'public');
            $imageUrl = asset('storage/' . $imagePath);
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

        // Save the choices or choice images associated with the question
        if ($request->has('choices')) {
            foreach ($validatedData['choices'] as $index => $choice) {
                $questionChoice = new Choice();
                $questionChoice->question_id = $question->id;
                $questionChoice->choice = $choice;
                // Check if the current choice is marked as correct
                $questionChoice->is_correct = $validatedData['is_correct'][$index]; // Assume 'is_correct' array is aligned with 'choices' array
                $questionChoice->created_by = $user->id;
                $questionChoice->updated_by = $user->id;

                // Handle choice image upload
                if ($request->hasFile('choice_images.' . $index)) {
                    $imagePath = $request->file('choice_images.' . $index)->store('choice_images', 'public');
                    $questionChoice->image_choice = $imagePath;
                }

                $questionChoice->save();
            }
        }

        return redirect()->back()->with('success', 'Question created successfully!');
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        // Validate the request data
        $validatedData = $request->validate([
            'quiz_id' => 'required', // Assuming quiz_id cannot be changed
            'question' => 'required|string',
            'point_value' => 'required',
            'question_type' => 'required',
            'questionImage' => 'nullable|image|mimes:jpeg,png,jpg,gif', // Add validation for question image
            'choices' => 'required_without:choice_images|array',
            'choices.*' => 'required_without:choice_images', // Require string for each choice if choice_images are not provided
            'is_correct' => 'required|array', // Make is_correct field required
            'is_correct.*' => 'required|boolean', // Make each is_correct value a boolean
            'choice_images' => 'required_without:choices|array',
            'choice_images.*' => 'required_without:choices.*|image', // Validation for choice images
        ]);

        // Get the authenticated user
        $updatedBy = Auth::user()->id;

        // Find the question by ID
        $question = Question::findOrFail($id);

        // Ensure that the number of is_correct values matches the number of choices
        if (count($validatedData['choices']) !== count($validatedData['is_correct'])) {
            return redirect()->back()->withErrors(['is_correct' => 'The number of is_correct values must match the number of choices.'])->withInput();
        }

        // Check if at least one choice is marked as correct
        if (!in_array(true, $validatedData['is_correct'])) {
            return redirect()->back()->withErrors(['is_correct' => 'At least one choice must be marked as correct.'])->withInput();
        }

        if ($request->hasFile('questionImage')) {
            // Store the question image
            $imagePath = $request->file('questionImage')->store('question_images', 'public');
            // Construct the image URL
            $imageUrl = asset('storage/' . $imagePath);
        } else {
            // Keep the existing image URL if no new image is uploaded
            $imageUrl = $question->images;
        }

        // Update question details including the image URL
        $question->update([
            'question' => $validatedData['question'],
            'point_value' => $validatedData['point_value'],
            'question_type' => $validatedData['question_type'],
            'images' => $imageUrl ?: $question->images, // Update the image URL
            'updated_by' => $updatedBy,
        ]);

        // Get the IDs of choices present in the submitted form
        $submittedChoiceIds = collect($validatedData['choices'])->pluck('id')->filter();

        // Get the IDs of existing choices associated with the question
        $existingChoiceIds = $question->choices->pluck('id');

        // Determine which choices should be deleted
        $choicesToDelete = $existingChoiceIds->diff($submittedChoiceIds);

        // Delete the choices that are not present in the submitted form
        Choice::whereIn('id', $choicesToDelete)->delete();

        // Handle new choices added dynamically
        foreach ($validatedData['choices'] as $index => $choice) {
            if (!isset($choice['id'])) {
                $image_choice = null;

                if (isset($choice['image'])) {
                    // Retrieve the uploaded image
                    $image = $choice['image'];
                    $imagePath = $image->store('choice_images', 'public');
                    $image_choice = $imagePath;
                }

                $newChoice = Choice::query();
                $newChoice->create([
                    'choice' => $choice['text'],
                    'question_id' => $question->id,
                    'is_correct' => $validatedData['is_correct'][$index] ?? false,
                    'updated_by' => $updatedBy,
                    'created_by' => $updatedBy,
                    'image_choice' => $image_choice
                ]);
            } else {
                // Retrieve the existing choice by its id
                $existingChoice = Choice::find($choice['id']);

                if ($existingChoice) {
                    // Check if a new image is uploaded
                    if (isset($choice['image'])) {
                        $image_choice = null;

                        // Check if an image was uploaded for the choice
                        if (isset($choice['image'])) {
                            // Retrieve the uploaded image
                            $image = $choice['image'];

                            // Process the uploaded image
                            $imagePath = $image->store('choice_images', 'public');
                            $image_choice = $imagePath;
                        }
                    } else {
                        // Keep the existing image path
                        $image_choice = $existingChoice->image_choice;
                    }

                    // Update the existing choice with new data
                    $existingChoice->update([
                        'choice' => $choice['text'],  // Update choice text if applicable
                        'is_correct' => $validatedData['is_correct'][$index] ?? false,
                        'updated_by' => $updatedBy,
                        'image_choice' => $image_choice
                    ]);
                }
            }
        }

        return redirect()->back()->with('success', 'Question updated successfully!');
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

    public function essayUpdate(Request $request, string $id)
    {
        // Validate the request data
        $validatedData = $request->validate([
            'quiz_id' => 'required|exists:quizzes,id',
            'question' => 'required|string',
            'essayImage' => 'nullable|image|mimes:jpeg,png,jpg,gif', // Add validation for essay image
        ]);

        // Find the essay question by ID
        $question = Question::findOrFail($id);

        // Handle essay image upload
        if ($request->hasFile('essayImage')) {
            // Delete the old essay image if it exists
            if ($question->images) {
                Storage::disk('public')->delete($question->images);
            }
            // Store the new essay image
            $imagePath = $request->file('essayImage')->store('essay_images', 'public');
            $imageUrl = asset('storage/' . $imagePath);
        } else {
            $imageUrl = $question->images; // Keep the existing image URL if no new image is uploaded
        }

        // Update the essay question details
        $question->update([
            'quiz_id' => $validatedData['quiz_id'],
            'question' => $validatedData['question'],
            'images' => $imageUrl, // Update the essay image URL
        ]);

        // Redirect back or return a response
        return redirect()->back()->with('success', 'Essay question updated successfully!');
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
            'choices' => 'required_without:choice_images|array',
            'choices.*' => 'required_without:choice_images.*', // Require string for each choice if choice_images are not provided
            'point_value' => 'required|array',
            'point_value.*' => 'numeric|min:0',
            'choice_images' => 'required_without:choices|array',
            'choice_images.*' => 'required_without:choices.*|image', // Validation for choice images
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

    public function weightedUpdate(Request $request, $questionId)
    {
        // Validate the form data
        $rules = [
            'question_type' => 'required|string',
            'quiz_id' => 'required|exists:quizzes,id',
            'question' => 'required|string',
            'choices' => 'required_without:choice_images|array',
            'choices.*' => 'required_without:choice_images.*|string', // Each choice is required without its corresponding image
            'point_value' => 'required|array',
            'point_value.*' => 'numeric|min:0',
            'choice_ids' => 'array',
            'choice_ids.*' => 'integer|exists:choices,id',
            'choice_images' => 'required_without:choices|array',
            'choice_images.*' => 'required_without:choices.*|image', // Each image is required without its corresponding choice
        ];

        $validatedData = $request->validate($rules);

        // Get the currently authenticated user
        $user = Auth::user();

        // Find the question by ID
        $question = Question::findOrFail($questionId);

        // Handle question image upload
        if ($request->hasFile('weightedEssayImage')) {
            $imagePath = $request->file('weightedEssayImage')->store('weighted_essay_images', 'public');
            $imageUrl = asset('storage/' . $imagePath);
        } else {
            $imageUrl = $question->images; // Keep the existing image if no new image is uploaded
        }

        // Update the question
        $question->update([
            'question' => $validatedData['question'],
            'question_type' => $validatedData['question_type'],
            'updated_by' => $user->id,
            'images' => $imageUrl, // Update the image URL if changed
        ]);

        // Collect the IDs of the existing choices that are present in the form submission
        $submittedChoiceIds = $validatedData['choice_ids'] ?? [];

        // Delete choices that are not present in the form submission

        // Update existing choices and add new ones if necessary
        // Array to collect IDs of choices that should not be deleted
        $allChoiceIdsToKeep = [];

        foreach ($validatedData['choices'] as $index => $choice) {
            $pointValue = $validatedData['point_value'][$index];
            if (isset($submittedChoiceIds[$index])) {
                // Update existing choice
                $choiceId = $submittedChoiceIds[$index];
                $questionChoice = $question->choices()->find($choiceId);
                if ($questionChoice) {
                    $questionChoice->update([
                        'choice' => $choice,
                        'point_value' => $pointValue,
                        'updated_by' => $user->id,
                    ]);

                    // Check if there's a new image for the existing choice
                    if ($request->hasFile('choice_images.' . $index)) {
                        // Delete the old image if it exists
                        if ($questionChoice->image_choice) {
                            Storage::disk('public')->delete($questionChoice->image_choice);
                        }
                        // Upload the new image and update the choice's image field
                        $imagePath = $request->file('choice_images.' . $index)->store('choice_images', 'public');
                        $questionChoice->image_choice = $imagePath;
                    }
                    $questionChoice->save();

                    // Add to array of choice IDs to keep
                    $allChoiceIdsToKeep[] = $choiceId;
                }
            } else {
                // Create new choice
                $newChoice = new Choice([
                    'choice' => $choice,
                    'point_value' => $pointValue,
                    'created_by' => $user->id,
                    'updated_by' => $user->id,
                    'question_id' => $question->id,
                ]);

                // Handle new choice image upload
                if ($request->hasFile('choice_images.' . $index)) {
                    $imagePath = $request->file('choice_images.' . $index)->store('choice_images', 'public');
                    $newChoice->image_choice = $imagePath;
                }

                $newChoice->save();

                // Add new choice ID to the array of choice IDs to keep
                $allChoiceIdsToKeep[] = $newChoice->id;
            }
        }

        // Now delete choices not in the collected IDs
        $question->choices()
            ->whereNotIn('id', $allChoiceIdsToKeep)
            ->delete();

        // Handle choices that only have images and no text
        foreach ($request->file('choice_images', []) as $index => $file) {
            if (!isset($submittedChoiceIds[$index]) && !isset($validatedData['choices'][$index])) {
                // Create a new choice with an image
                $newChoice = new Choice([
                    'point_value' => $validatedData['point_value'][$index],
                    'created_by' => $user->id,
                    'updated_by' => $user->id,
                    'question_id' => $question->id,
                ]);

                // Upload the image and update the choice's image field
                $imagePath = $file->store('choice_images', 'public');
                $newChoice->image_choice = $imagePath;

                $newChoice->save();
            }
        }

        // Redirect back or return a response
        return redirect()->back()->with('success', 'Question updated successfully!');
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
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $question = Question::where('id', $id);
        $question->delete();

        return redirect()->back()->with('success', 'Question deleted successfully!');
    }
}
