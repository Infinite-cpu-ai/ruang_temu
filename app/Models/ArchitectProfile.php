<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ArchitectProfile extends Model
{
    protected $fillable = [
        'user_id', 'specialization', 'price_per_m2', 
        'rating', 'location', 'style', 'portfolio_images'
    ];

    protected $casts = [
        'portfolio_images' => 'array', // Automatically cast JSON to array
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
