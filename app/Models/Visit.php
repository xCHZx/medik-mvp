<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class Visit extends Model
{
    use HasFactory;
    use SoftDeletes;

    public function business(): BelongsTo
    {
        return $this->belongsTo(Business::class, 'id');
    }

    public function visitor(): BelongsTo
    {
        return $this->belongsTo(Visitor::class, 'id');
    }

    public function reviews(): HasMany
    {
        return $this->hasMany(Review::class, 'visitId');
    }
}
