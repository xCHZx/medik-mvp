<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

class Review extends Model
{
    use HasFactory;
    use SoftDeletes;

    public function visit(): BelongsTo
    {
        return $this->belongsTo(Visit::class, 'visitId');
    }

    public function flow() : BelongsTo
    {
        return $this->belongsTo(Flow::class, 'flowId');
    }
}
