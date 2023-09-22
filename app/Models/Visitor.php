<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\SoftDeletes;

class Visitor extends Model
{
    use HasFactory;
    use SoftDeletes;

    public function visits(): HasMany
    {
        return $this->hasMany(Visit::class, 'visitorId', 'id');
    }

    public function lastVisit(): HasOne
    {
        // return $this->hasOne(Visit::class, 'visitorId', 'id')->skip(1)->take(1)->latest();
        return $this->hasOne(Visit::class, 'visitorId')->skip(1)->take(1)->latest();
    }
}
