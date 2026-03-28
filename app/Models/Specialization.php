<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Specialization extends Model
{
    protected $fillable = ['name', 'description'];

    public function architectProfiles(): BelongsToMany
    {
        return $this->belongsToMany(ArchitectProfile::class, 'architect_specialization');
    }
}
