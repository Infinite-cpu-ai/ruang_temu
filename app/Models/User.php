<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Database\Factories\UserFactory;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Attributes\Hidden;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

#[Fillable(['name', 'email', 'password'])]
#[Hidden(['password', 'remember_token'])]
class User extends Authenticatable
{
    /** @use HasFactory<UserFactory> */
    use HasFactory, Notifiable;

    protected $fillable = [
        'name', 'email', 'password', 'role', 'is_active', 'is_premium', 'premium_expires_at',
    ];

    protected $hidden = [
        'password', 'remember_token',
    ];

    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
            'is_premium' => 'boolean',
            'premium_expires_at' => 'datetime',
        ];
    }

    public function isPremium(): bool
    {
        if (! $this->is_premium) {
            return false;
        }

        // If expiry is set and has passed, no longer premium
        if ($this->premium_expires_at && $this->premium_expires_at->isPast()) {
            return false;
        }

        return true;
    }

    public function answers(): HasMany
    {
        return $this->hasMany(Answer::class, 'architect_id');
    }

    public function architectProfile(): HasOne
    {
        return $this->hasOne(ArchitectProfile::class);
    }

    public function clientProjects(): HasMany
    {
        return $this->hasMany(Project::class, 'user_id');
    }

    public function architectProjects(): HasMany
    {
        return $this->hasMany(Project::class, 'architect_id');
    }

    public function sentMessages(): HasMany
    {
        return $this->hasMany(Message::class, 'sender_id');
    }

    public function receivedMessages(): HasMany
    {
        return $this->hasMany(Message::class, 'receiver_id');
    }

    public function reviewsAsClient(): HasMany
    {
        return $this->hasMany(Review::class, 'client_id');
    }

    public function reviewsAsArchitect(): HasMany
    {
        return $this->hasMany(Review::class, 'architect_id');
    }

    public function followingArchitects(): BelongsToMany
    {
        return $this->belongsToMany(
            User::class,
            'follows',
            'user_id',
            'architect_id'
        )->withTimestamps();
    }

    public function followers(): BelongsToMany
    {
        return $this->belongsToMany(
            User::class,
            'follows',
            'architect_id',
            'user_id'
        )->withTimestamps();
    }
}
