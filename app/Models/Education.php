<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Education extends Model
{
    use HasFactory, SoftDeletes;

    protected $dates = ['deleted_at'];
    protected $guarded = ['id'];

    public function users(){
        return $this->hasMany(User::class);
    }

    public function questions(){
        return $this->hasMany(Question::class);
    }

    public function quizzes(){
        return $this->hasMany(Quiz::class);
    }
}
