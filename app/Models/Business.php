<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\SoftDeletes;

class Business extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $table = 'businesses';

    protected $fillable = [
        'name',
        'description',
        'imageUrl',
        'userId',
        'qrPath',
    ];

    public function visits(): HasMany
    {
        return $this->hasMany(Visit::class, 'businessId', 'id');
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'userId');
    }

    public function flows(): HasMany
    {
        return $this->hasMany(Flow::class , 'businessId');
    }

}
