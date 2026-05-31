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

    protected function imageUrl(): \Illuminate\Database\Eloquent\Casts\Attribute
    {
        return \Illuminate\Database\Eloquent\Casts\Attribute::make(
            get: function () {
                if (!$this->image) {
                    return '';
                }
                
                if (str_starts_with($this->image, 'http')) {
                    return $this->image;
                }
                
                return \Illuminate\Support\Facades\Storage::url($this->image);
            }
        );
    }
}
