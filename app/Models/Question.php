<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Question extends Model
{
    use HasFactory, SoftDeletes;

    protected $dates = ['deleted_at'];
    protected $guarded = ['id'];

    protected static function boot()
    {
        parent::boot();

        static::created(function ($question) {
            $question->quiz->calculateMaxScore();
        });

        static::updated(function ($question) {
            $question->quiz->calculateMaxScore();
        });

        static::deleted(function ($question) {
            $question->quiz->calculateMaxScore();
        });
    }

    public function quiz()
    {
        return $this->belongsTo(Quiz::class);
    }

    public function choices()
    {
        return $this->hasMany(Choice::class);
    }

    public function userAnswer()
    {
        return $this->hasMany(UserAnswer::class);
    }
}
