<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Flow extends Model
{
    use HasFactory;

    protected $table = 'flows';

    protected $fillable = [
        'name',
        'objetivo',
        'isActive',
        'businessId'

    ];

    // La relacion con el negocio al que pertenece cada flujo
    public function business(): BelongsTo
    {
        return $this->belongsTo(Business::class,'businessId');
    }

    public function calificationLinks(): HasMany
    {
        return $this->hasMany(CalificactionLink::class , 'flowId');
    }




}
