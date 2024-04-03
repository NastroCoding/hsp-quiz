<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Choice extends Model
{
    use HasFactory;

    protected $dates = ['deleted_at'];
    protected $guarded = ['id'];

    public function question(){
        return $this->belongsTo(Question::class);
    }

    public function userAnswer(){
        return $this->hasMany(User_Answer::class);
    }
}
