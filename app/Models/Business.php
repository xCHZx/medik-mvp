<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasManyThrough;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\SoftDeletes;

class Business extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $table = 'businesses';

    protected $fillable = [

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

    public function reviews(): HasManyThrough
    {
        return $this->hasManyThrough(Review::class, Visit::class, 'businessId', 'visitId');
    }

    // public function visitors(): HasManyThrough
    // {
    //     // return $this->hasManyThrough(Visitor::class, Visit::class, 'visitorId');
    //     return $this->through('visits')->has('visitor');
    // }

}
