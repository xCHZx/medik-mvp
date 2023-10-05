<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

class Flow extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $table = 'flows';

    protected $fillable = [
        'name', // Nombre del flujo
        'description', // Descripción opcional
        'businessId', // ID del negocio al que pertenece este flujo
        'isOn', // Estado del flujo (encendido o apagado)
    ];

    public function business(): BelongsTo
    {
        return $this->belongsTo(Business::class, 'businessId');
    }
}
