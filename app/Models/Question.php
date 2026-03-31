<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Question extends Model
{
    protected $fillable = [
        'client_id',
        'session_id',
        'content',
        'status',
        'architect_id',
        'claimed_at',
        'answered_at',
    ];

    protected $casts = [
        'claimed_at' => 'datetime',
        'answered_at' => 'datetime',
    ];

    public function client()
    {
        return $this->belongsTo(User::class, 'client_id');
    }

    public function architect()
    {
        return $this->belongsTo(User::class, 'architect_id');
    }

    public function answer()
    {
        return $this->hasOne(Answer::class);
    }
}
