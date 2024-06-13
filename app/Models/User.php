<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use HasFactory, Notifiable;
    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    use SoftDeletes;

    protected $dates = ['deleted_at'];

    protected $fillable = [
        'name',
        'role',
        'image',
        'email',
        'password',
        'created_by',
        'updated_by',
        'education_id', // Add this line
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    public function education()
    {
        return $this->belongsTo(Education::class);
    }

    public function useranswer()
    {
        return $this->hasMany(UserAnswer::class);
    }

    public function quizResults()
    {
        return $this->hasMany(QuizResult::class);
    }

    public function scores()
    {
        return $this->hasMany(UserScore::class);
    }

    public function calculateScoresForQuiz($quiz_id)
    {
        // Fetch all questions for the quiz
        $questions = Question::with('choices')->where('quiz_id', $quiz_id)->get();

        // Initialize scores
        $totalPoints = 0;
        $userScore = 0;

        // Calculate scores
        foreach ($questions as $question) {
            $totalPoints += $question->point_value;

            // Get the user's answer for the current question
            $userAnswer = $this->useranswer->where('question_id', $question->id)->first();

            if ($userAnswer) {
                // Find the selected choice
                $choice = $question->choices->firstWhere('id', $userAnswer->choosen_choice_id);
                
                if ($choice && $choice->is_correct) {
                    
                    // Add points based on the question's point value
                    $userScore += $question->point_value;

                    // Add points based on the choice's point value
                    $userScore += $choice->point_value;
                }
            }
        }

        return (object)[
            'totalPoints' => $totalPoints,
            'userScore' => $userScore,
        ];
    }
}
