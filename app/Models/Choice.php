<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Choice extends Model
{
    use HasFactory;

    protected $dates = ['deleted_at'];
    protected $guarded = ['id'];

    protected static function boot()
    {
        parent::boot();

        static::created(function ($choice) {
            $choice->question->quiz->calculateMaxScore();
        });

        static::updated(function ($choice) {
            $choice->question->quiz->calculateMaxScore();
        });

        static::deleted(function ($choice) {
            $choice->question->quiz->calculateMaxScore();
        });
    }

    public function question()
    {
        return $this->belongsTo(Question::class);
    }

    public function userAnswer()
    {
        return $this->hasMany(UserAnswer::class);
    }
}
