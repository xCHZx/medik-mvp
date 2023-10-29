<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class CalificationLink extends Model
{
    use HasFactory;
    protected $table = 'calification_links';


    protected $fillable = [
        'name',
        'url',
        'flowId',

    ];

    public function flows(): BelongsTo
    {
        return $this->belongsTo(Flow::class , 'flowId');
    }

    
}
