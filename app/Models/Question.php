<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Question extends Model
{
    use HasFactory;

    protected $dates = ['deleted_at'];
    protected $guarded = ['id'];
    protected $fillable = ['quiz_id', 'text', 'type'];

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

    public function options()
    {
        return $this->hasMany(Option::class);
    }

    public function userAnswers()
    {
        return $this->hasMany(UserAnswer::class);
    }
}
