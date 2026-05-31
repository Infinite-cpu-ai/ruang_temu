<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

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
        'timeline',
        'bank_accounts',
        'qris_image',
    ];

    protected $casts = [
        'project_types' => 'array',
        'portfolio_images' => 'array', // Automatically cast JSON to array
        'bank_accounts' => 'array',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function portfolios(): HasMany
    {
        return $this->hasMany(Portfolio::class);
    }

    public function specializations(): BelongsToMany
    {
        return $this->belongsToMany(Specialization::class, 'architect_specialization');
    }

    protected function profileImageUrl(): \Illuminate\Database\Eloquent\Casts\Attribute
    {
        return \Illuminate\Database\Eloquent\Casts\Attribute::make(
            get: function () {
                if (!$this->profile_image) {
                    return asset('images/profiles/profile_placeholder.png');
                }
                
                if (str_starts_with($this->profile_image, 'http')) {
                    return $this->profile_image;
                }
                
                return \Illuminate\Support\Facades\Storage::url($this->profile_image);
            }
        );
    }

    protected function qrisImageUrl(): \Illuminate\Database\Eloquent\Casts\Attribute
    {
        return \Illuminate\Database\Eloquent\Casts\Attribute::make(
            get: function () {
                if (!$this->qris_image) {
                    return '';
                }
                
                if (str_starts_with($this->qris_image, 'http')) {
                    return $this->qris_image;
                }
                
                return \Illuminate\Support\Facades\Storage::url($this->qris_image);
            }
        );
    }
}
