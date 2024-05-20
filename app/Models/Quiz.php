<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Quiz extends Model
{
    use HasFactory;

    protected $dates = ['deleted_at'];
    protected $guarded = ['id'];
    protected $fillable = ['title', 'user_id'];

    public function questions(){
        return $this->hasMany(Question::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function category(){
        return $this->belongsTo(Category::class);
    }

    public function education(){
        return $this->belongsTo(Education::class);
    }
}
