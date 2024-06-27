<?php

namespace App\Http\Controllers;

use App\Models\Choice;
use App\Models\Question;
use App\Models\Quiz;
use App\Models\User;
use App\Models\UserAnswer;
use App\Models\UserEssay;
use App\Models\UserScore;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class UserAnswerController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request, $quiz_id)
    {
        
        $questions = Question::where('quiz_id', $quiz_id)->get();

        
        $totalPoint = 0;
        $rightAnswerCount = 0;

        foreach ($questions as $question) {
            $totalPoint += $question->point_value;

            $userAnswers = UserAnswer::where([
                'user_id' => $request->user()->id,
                'question_id' => $question->id
            ])->get();

            foreach ($userAnswers as $userAnswer) {
                $choice = Choice::find($userAnswer->choosen_choice_id);

                $choiceSum = Choice::where([
                    'question_id' => $question->id,
                    'id' => $userAnswer->choosen_choice_id,
                ])->get();
                foreach ($choiceSum as $cho) {
                    $maxScore = $cho->max('point_value');
                    $rightAnswerCount += $cho->point_value;
                    break;
                }

                if ($choice && $choice->is_correct) {
                    $rightAnswerCount += $question->point_value;
                    break;
                }
            }
        }

        $totalPoint += $maxScore;

        return response()->json([
            'totalPoints' => $totalPoint,
            'rightAnswerCount' => $rightAnswerCount
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request, $quiz_id)
    {
        
        $validatedData = $request->validate([
            'question_id' => 'required|exists:questions,id',
            'choosen_choice_id' => 'required|exists:choices,id',
        ]);

        
        $chosenChoice = Choice::findOrFail($validatedData['choosen_choice_id']);

        
        $isCorrect = $chosenChoice->is_correct;

        
        $validatedData['user_id'] = Auth::id();
        $validatedData['is_correct'] = $isCorrect;

        
        $validatedData['created_by'] = Auth::id();
        $validatedData['updated_by'] = Auth::id();

        
        $existingAnswer = UserAnswer::where('user_id', Auth::id())
            ->where('question_id', $validatedData['question_id'])
            ->first();

        
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

        $scoreCheck = UserScore::where([
            'quiz_id' => $quiz_id,
            'user_id' => Auth::id()
        ])->first();

        $user = User::find(Auth::id());
        $calc = $user->calculateScoresForQuiz($quiz_id);
        $rightAnswerCount = $calc->userScore;

        if (!$scoreCheck) {
            $score = UserScore::create([
                'user_id' => Auth::id(),
                'quiz_id' => $quiz_id,
                'score' => $rightAnswerCount
            ]);
        } else {
            $scoreCheck->update([
                'score' => $rightAnswerCount
            ]);
        }

        return redirect('/quiz')->with('success', $message);
    }

    /**
     * Store a newly created essay answer in storage.
     */
    public function storeEssayAnswer(Request $request, $quiz_id)
    {
        
        $validatedData = $request->validate([
            'question_id' => 'required|exists:questions,id',
            'essay_answer' => 'required|string',
        ]);

        
        $validatedData['user_id'] = Auth::id();

        $validatedData['created_by'] = Auth::id();
        $validatedData['updated_by'] = Auth::id();

        try {
            
            $existingAnswer = UserEssay::where('user_id', Auth::id())
                ->where('question_id', $validatedData['question_id'])
                ->first();

            
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

            $scoreCheck = UserScore::where([
                'quiz_id' => $quiz_id,
                'user_id' => Auth::id()
            ])->first();

            $user = User::find(Auth::id());
            $calc = $user->calculateScoresForQuiz($quiz_id);
            $rightAnswerCount = $calc->userScore;

            if (!$scoreCheck) {
                $score = UserScore::create([
                    'user_id' => Auth::id(),
                    'quiz_id' => $quiz_id,
                    'score' => $rightAnswerCount
                ]);
            } else {
                $scoreCheck->update([
                    'score' => $rightAnswerCount
                ]);
            }

            return redirect('/quiz')->with('success', $message);
        } catch (\Exception $e) {
            
            Log::error('Error storing essay answer: ' . $e->getMessage(), $validatedData);

            
            return redirect('/quiz')->with('error', 'There was a problem submitting your answer. Please try again.');
        }
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        
        $essay = UserEssay::findOrFail($id);

        
        return view('essay.show', ['essay_answer' => $essay->answer]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, UserAnswer $userAnswer)
    {
        
    }

    /**
     * Remove the specified resource from storage.
     */
    public function deleteAnswer(Request $request, $quiz_id)
    {
        
        $validatedData = $request->validate([
            'question_id' => 'required|exists:questions,id',
        ]);

        
        $existingAnswer = UserAnswer::where('user_id', Auth::id())
            ->where('question_id', $validatedData['question_id'])
            ->first();

        if ($existingAnswer) {
            $existingAnswer->delete();
            $message = 'Your answer has been deleted successfully!';
        } else {
            $message = 'No answer found to delete!';
        }

        
        $user = User::find(Auth::id());
        $calc = $user->calculateScoresForQuiz($quiz_id);
        $rightAnswerCount = $calc->userScore;

        $scoreCheck = UserScore::where([
            'quiz_id' => $quiz_id,
            'user_id' => Auth::id()
        ])->first();

        if ($scoreCheck) {
            $scoreCheck->update([
                'score' => $rightAnswerCount
            ]);
        }

        return response()->json(['success' => true, 'message' => $message]);
    }
}
