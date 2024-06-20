<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use HasFactory, Notifiable, SoftDeletes;
    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */

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
        $userScore = 0;

        // Calculate scores
        foreach ($questions as $question) {
            $userAnswer = $this->useranswer->where('question_id', $question->id)->first();
            if ($userAnswer) {
                $choice = $question->choices->firstWhere('id', $userAnswer->choosen_choice_id);
                $userScore += $choice->point_value;
                
                if ($choice && $choice->is_correct) {
                    $userScore += $question->point_value;
                }
            }
        }

        return (object)[
            'userScore' => $userScore,
        ];
        
    }
}
