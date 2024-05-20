<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserAnswer extends Model
{
    use HasFactory;

    protected $dates = ['deleted_at'];
    protected $guarded = ['id'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function question()
    {
        return $this->belongsTo(Question::class);
    }

    public function choosenChoice()
    {
        return $this->belongsTo(Choice::class, 'choosen_choice_id');
    }

    // Define a custom accessor to retrieve is_correct from the related Choice model
    public function getIsCorrectAttribute()
    {
        return $this->choosenChoice->is_correct;
    }
}
