<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ArchitectProfile extends Model
{
    protected $fillable = [
        'user_id',
        'specialization',
        'project_types',
        'price_per_m2',
        'rating',
        'location',
        'style',
        'portfolio_images',
        'profile_image',
    ];

    protected $casts = [
        'project_types' => 'array',
        'portfolio_images' => 'array', // Automatically cast JSON to array
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
