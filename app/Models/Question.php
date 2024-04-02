<?php

namespace App\Models;

use Illuminate\Console\View\Components\Choice;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Question extends Model
{
    use HasFactory;
    
    protected $dates = ['deleted_at'];
    protected $guarded = ['id'];

    public function question_choices(){
        return $this->hasMany(Choice::class);
    }

    public function quiz(){
        return $this->belongsTo(Quiz::class);
    }
}
