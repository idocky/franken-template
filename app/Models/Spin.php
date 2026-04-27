<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Spin extends Model
{
    protected $fillable = [
        'user_id',
        'result',
        'points',
        'random_number',
    ];

    protected $casts = [
        'points' => 'decimal:2',
        'random_number' => 'integer',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
