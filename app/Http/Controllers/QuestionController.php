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
        
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        
        $validatedData = $request->validate([
            'quiz_id' => 'required|exists:quizzes,id', 
            'question' => 'required|string',
            'point_value' => 'required|numeric', 
            'question_type' => 'required|string',
            'questionImage' => 'nullable|image', 
            'choices' => 'required_without:choice_images|array',
            'choices.*' => 'required_without:choice_images.*', 
            'is_correct' => 'required|array', 
            'is_correct.*' => 'required|boolean', 
            'choice_images' => 'required_without:choices|array',
            'choice_images.*' => 'required_without:choices.*|image', 
        ]);

        if (count($validatedData['choices']) !== count($validatedData['is_correct'])) {
            return redirect()->back()->withErrors(['is_correct' => 'The number of is_correct values must match the number of choices.'])->withInput();
        }

        if (!in_array(true, $validatedData['is_correct'])) {
            return redirect()->back()->withErrors(['is_correct' => 'At least one choice must be marked as correct.'])->withInput();
        }

        $imageUrl = null;
        if ($request->hasFile('questionImage')) {
            $imagePath = $request->file('questionImage')->store('question_images', 'public');
            $imageUrl = asset('storage/' . $imagePath);
        }

        $user = Auth::user();
        $lastQuestionNumber = Question::where('quiz_id', $validatedData['quiz_id'])->max('number') ?? 0;

        $question = new Question();
        $question->question = $validatedData['question'];
        $question->point_value = $validatedData['point_value'];
        $question->question_type = $validatedData['question_type'];
        $question->quiz_id = $validatedData['quiz_id']; 
        $question->created_by = $user->id;
        $question->updated_by = $user->id;
        $question->number = $lastQuestionNumber + 1;
        $question->images = $imageUrl; 
        $question->save();

        
        if ($request->has('choices')) {
            foreach ($validatedData['choices'] as $index => $choice) {
                $questionChoice = new Choice();
                $questionChoice->question_id = $question->id;
                $questionChoice->choice = $choice;
                
                $questionChoice->is_correct = $validatedData['is_correct'][$index]; 
                $questionChoice->created_by = $user->id;
                $questionChoice->updated_by = $user->id;

                
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
        
        $validatedData = $request->validate([
            'quiz_id' => 'required', 
            'question' => 'required|string',
            'point_value' => 'required',
            'question_type' => 'required',
            'questionImage' => 'nullable|image|mimes:jpeg,png,jpg,gif', 
            'choices' => 'required_without:choice_images|array',
            'choices.*' => 'required_without:choice_images', 
            'is_correct' => 'required|array', 
            'is_correct.*' => 'required|boolean', 
            'choice_images' => 'required_without:choices|array',
            'choice_images.*' => 'required_without:choices.*|image', 
        ]);

        
        $updatedBy = Auth::user()->id;

        
        $question = Question::findOrFail($id);

        
        if (count($validatedData['choices']) !== count($validatedData['is_correct'])) {
            return redirect()->back()->withErrors(['is_correct' => 'The number of is_correct values must match the number of choices.'])->withInput();
        }

        
        if (!in_array(true, $validatedData['is_correct'])) {
            return redirect()->back()->withErrors(['is_correct' => 'At least one choice must be marked as correct.'])->withInput();
        }

        if ($request->hasFile('questionImage')) {
            
            $imagePath = $request->file('questionImage')->store('question_images', 'public');
            
            $imageUrl = asset('storage/' . $imagePath);
        } else {
            
            $imageUrl = $question->images;
        }

        
        $question->update([
            'question' => $validatedData['question'],
            'point_value' => $validatedData['point_value'],
            'question_type' => $validatedData['question_type'],
            'images' => $imageUrl ?: $question->images, 
            'updated_by' => $updatedBy,
        ]);

        
        $submittedChoiceIds = collect($validatedData['choices'])->pluck('id')->filter();

        
        $existingChoiceIds = $question->choices->pluck('id');

        
        $choicesToDelete = $existingChoiceIds->diff($submittedChoiceIds);

        
        Choice::whereIn('id', $choicesToDelete)->delete();

        
        foreach ($validatedData['choices'] as $index => $choice) {
            if (!isset($choice['id'])) {
                $image_choice = null;

                if (isset($choice['image'])) {
                    
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
                
                $existingChoice = Choice::find($choice['id']);

                if ($existingChoice) {
                    
                    if (isset($choice['image'])) {
                        $image_choice = null;

                        
                        if (isset($choice['image'])) {
                            
                            $image = $choice['image'];

                            
                            $imagePath = $image->store('choice_images', 'public');
                            $image_choice = $imagePath;
                        }
                    } else {
                        
                        $image_choice = $existingChoice->image_choice;
                    }

                    
                    $existingChoice->update([
                        'choice' => $choice['text'],  
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
        
        $validatedData = $request->validate([
            'question_type' => 'required|string',
            'quiz_id' => 'required|exists:quizzes,id',
            'question' => 'required|string',
            'essayImage' => 'nullable|image', 
        ]);

        
        $user = Auth::user();
        $lastQuestionNumber = Question::where('quiz_id', $request->quiz_id)->max('number') ?? 0;

        
        if ($request->hasFile('essayImage')) {
            $imagePath = $request->file('essayImage')->store('essay_images', 'public');
            $imageUrl = asset('storage/' . $imagePath);
        } else {
            $imageUrl = null;
        }

        
        $question = new Question();
        $question->quiz_id = $validatedData['quiz_id'];
        $question->point_value = 0; 
        $question->question = $validatedData['question'];
        $question->question_type = $validatedData['question_type'];
        $question->created_by = $user->id;
        $question->updated_by = $user->id;
        $question->number = $lastQuestionNumber + 1;
        $question->images = $imageUrl; 
        $question->save();

        
        return redirect()->back()->with('success', 'Essay question created successfully!');
    }

    public function essayUpdate(Request $request, string $id)
    {
        
        $validatedData = $request->validate([
            'quiz_id' => 'required|exists:quizzes,id',
            'question' => 'required|string',
            'essayImage' => 'nullable|image|mimes:jpeg,png,jpg,gif', 
        ]);

        
        $question = Question::findOrFail($id);

        
        if ($request->hasFile('essayImage')) {
            
            if ($question->images) {
                Storage::disk('public')->delete($question->images);
            }
            
            $imagePath = $request->file('essayImage')->store('essay_images', 'public');
            $imageUrl = asset('storage/' . $imagePath);
        } else {
            $imageUrl = $question->images; 
        }

        
        $question->update([
            'quiz_id' => $validatedData['quiz_id'],
            'question' => $validatedData['question'],
            'images' => $imageUrl, 
        ]);

        
        return redirect()->back()->with('success', 'Essay question updated successfully!');
    }

    /**
     * Store a newly created weighted multiple choice question in storage.
     */
    public function weightedStore(Request $request)
    {
        
        $validatedData = $request->validate([
            'question_type' => 'required|string',
            'quiz_id' => 'required|exists:quizzes,id',
            'question' => 'required|string',
            'choices' => 'required_without:choice_images|array',
            'choices.*' => 'required_without:choice_images.*', 
            'point_value' => 'required|array',
            'point_value.*' => 'numeric|min:0',
            'choice_images' => 'required_without:choices|array',
            'choice_images.*' => 'required_without:choices.*|image', 
        ]);

        
        $user = Auth::user();
        $lastQuestionNumber = Question::where('quiz_id', $request->quiz_id)->max('number') ?? 0;

        
        if ($request->hasFile('weightedEssayImage')) {
            $imagePath = $request->file('weightedEssayImage')->store('weighted_essay_images', 'public');
            $imageUrl = asset('storage/' . $imagePath);
        } else {
            $imageUrl = null;
        }

        
        $question = Question::create([
            'quiz_id' => $validatedData['quiz_id'],
            'point_value' => 0,
            'question' => $validatedData['question'],
            'question_type' => $validatedData['question_type'],
            'created_by' => $user->id,
            'updated_by' => $user->id,
            'number' => $lastQuestionNumber + 1,
            'images' => $imageUrl, 
        ]);

        
        foreach ($validatedData['choices'] as $index => $choice) {
            $questionChoice = $question->choices()->create([
                'choice' => $choice,
                'is_correct' => false, 
                'point_value' => $validatedData['point_value'][$index],
                'created_by' => $user->id,
                'updated_by' => $user->id,
            ]);

            
            if ($request->hasFile('choice_images.' . $index)) {
                
                $imagePath = $request->file('choice_images.' . $index)->store('choice_images', 'public');
                $questionChoice->image_choice = $imagePath;
                $questionChoice->save();
            }
        }

        
        return redirect()->back()->with('success', 'Question created successfully!');
    }

    public function weightedUpdate(Request $request, $questionId)
    {
        
        $rules = [
            'question_type' => 'required|string',
            'quiz_id' => 'required|exists:quizzes,id',
            'question' => 'required|string',
            'choices' => 'required_without:choice_images|array',
            'choices.*' => 'required_without:choice_images.*|string', 
            'point_value' => 'required|array',
            'point_value.*' => 'numeric|min:0',
            'choice_ids' => 'array',
            'choice_ids.*' => 'integer|exists:choices,id',
            'choice_images' => 'required_without:choices|array',
            'choice_images.*' => 'required_without:choices.*|image', 
        ];

        $validatedData = $request->validate($rules);

        
        $user = Auth::user();

        
        $question = Question::findOrFail($questionId);

        
        if ($request->hasFile('weightedEssayImage')) {
            $imagePath = $request->file('weightedEssayImage')->store('weighted_essay_images', 'public');
            $imageUrl = asset('storage/' . $imagePath);
        } else {
            $imageUrl = $question->images; 
        }

        
        $question->update([
            'question' => $validatedData['question'],
            'question_type' => $validatedData['question_type'],
            'updated_by' => $user->id,
            'images' => $imageUrl, 
        ]);

        
        $submittedChoiceIds = $validatedData['choice_ids'] ?? [];

        

        
        
        $allChoiceIdsToKeep = [];

        foreach ($validatedData['choices'] as $index => $choice) {
            $pointValue = $validatedData['point_value'][$index];
            if (isset($submittedChoiceIds[$index])) {
                
                $choiceId = $submittedChoiceIds[$index];
                $questionChoice = $question->choices()->find($choiceId);
                if ($questionChoice) {
                    $questionChoice->update([
                        'choice' => $choice,
                        'point_value' => $pointValue,
                        'updated_by' => $user->id,
                    ]);

                    
                    if ($request->hasFile('choice_images.' . $index)) {
                        
                        if ($questionChoice->image_choice) {
                            Storage::disk('public')->delete($questionChoice->image_choice);
                        }
                        
                        $imagePath = $request->file('choice_images.' . $index)->store('choice_images', 'public');
                        $questionChoice->image_choice = $imagePath;
                    }
                    $questionChoice->save();

                    
                    $allChoiceIdsToKeep[] = $choiceId;
                }
            } else {
                
                $newChoice = new Choice([
                    'choice' => $choice,
                    'point_value' => $pointValue,
                    'created_by' => $user->id,
                    'updated_by' => $user->id,
                    'question_id' => $question->id,
                ]);

                
                if ($request->hasFile('choice_images.' . $index)) {
                    $imagePath = $request->file('choice_images.' . $index)->store('choice_images', 'public');
                    $newChoice->image_choice = $imagePath;
                }

                $newChoice->save();

                
                $allChoiceIdsToKeep[] = $newChoice->id;
            }
        }

        
        $question->choices()
            ->whereNotIn('id', $allChoiceIdsToKeep)
            ->delete();

        
        foreach ($request->file('choice_images', []) as $index => $file) {
            if (!isset($submittedChoiceIds[$index]) && !isset($validatedData['choices'][$index])) {
                
                $newChoice = new Choice([
                    'point_value' => $validatedData['point_value'][$index],
                    'created_by' => $user->id,
                    'updated_by' => $user->id,
                    'question_id' => $question->id,
                ]);

                
                $imagePath = $file->store('choice_images', 'public');
                $newChoice->image_choice = $imagePath;

                $newChoice->save();
            }
        }

        
        return redirect()->back()->with('success', 'Question updated successfully!');
    }



    /**
     * Display the specified resource.
     */
    public function show($slug)
    {
        
        $quiz = Quiz::where('slug', $slug)->first();
        $questions = $quiz->questions;
        
        if (!$quiz) {
            return response()->json(['message' => 'Quiz not found'], 404);
        }
        $lastQuestionNumber = Question::max('number') ?? 0;
        
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
        $question = Question::find($id);
        $quizId = $question->quiz_id;
        $question->delete();

        
        $questions = Question::where('quiz_id', $quizId)->orderBy('number')->get();
        foreach ($questions as $index => $question) {
            $question->number = $index + 1;
            $question->save();
        }

        return redirect()->back()->with('success', 'Question deleted successfully and questions re-ordered!');
    }
}
