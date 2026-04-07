<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Answer extends Model
{
    protected $fillable = [
        'question_id',
        'architect_id',
        'content',
        'rating',
        'rating_feedback',
    ];

    public function question()
    {
        return $this->belongsTo(Question::class);
    }

    public function architect()
    {
        return $this->belongsTo(User::class, 'architect_id');
    }
}
