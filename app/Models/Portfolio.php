<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Portfolio extends Model
{
    protected $fillable = ['architect_profile_id', 'title', 'description', 'image'];

    public function architectProfile(): BelongsTo
    {
        return $this->belongsTo(ArchitectProfile::class);
    }
}
