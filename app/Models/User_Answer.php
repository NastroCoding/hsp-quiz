<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class User_Answer extends Model
{
    use HasFactory;

    protected $dates = ['deleted_at'];
    protected $guarded = ['id'];

    public function user(){
        return $this->belongsTo(User::class);
    }

    public function question(){
        return $this->belongsTo(Question::class);
    }

    public function choosenChoice(){
        return $this->belongsTo(Choice::class, 'choosen_choice_id');
    }

}
