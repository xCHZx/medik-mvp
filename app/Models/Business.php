<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class Business extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $table = 'businesses';

    protected $fillable = [
        'name',
        'description',
        'userId',
        'qrPath',
    ];

    public function visits(): HasMany
    {
        return $this->hasMany(Visit::class, 'businessId', 'id');
    }
}
