<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class UserScore extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'user_id',
        'quiz_id',
        'score',
    ];

    // Define relationships if needed
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function quiz()
    {
        return $this->belongsTo(Quiz::class);
    }
}
