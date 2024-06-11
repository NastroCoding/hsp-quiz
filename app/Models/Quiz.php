<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Quiz extends Model
{
    use HasFactory;

    protected $dates = ['deleted_at'];
    protected $guarded = ['id'];

    public function questions()
    {
        return $this->hasMany(Question::class);
    }

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function education()
    {
        return $this->belongsTo(Education::class);
    }

    public function calculateMaxScore()
    {
        $maxScore = 0;

        foreach ($this->questions as $question) {
            // Add the point_value from the question itself
            $maxScore += $question->point_value;

            // Find the highest point_value among the choices for this question
            $maxChoice = $question->choices()->max('point_value');

            if ($maxChoice !== null) {
                $maxScore += $maxChoice;
            }
        }

        $this->max_score = $maxScore;
        $this->save();
    }
}
