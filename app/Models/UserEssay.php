<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class UserEssay extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'user_essay';

    protected $fillable = [
        'user_id',
        'question_id',
        'answer',
        'created_by',
        'updated_by',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'deleted_at' => 'datetime',
    ];

    /**
     * Get the user that owns the essay answer.
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Get the question that this essay answer is for.
     */
    public function question()
    {
        return $this->belongsTo(Question::class);
    }

    /**
     * Get the user who created the essay answer.
     */
    public function creator()
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    /**
     * Get the user who last updated the essay answer.
     */
    public function updater()
    {
        return $this->belongsTo(User::class, 'updated_by');
    }
}
