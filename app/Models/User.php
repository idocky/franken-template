<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    protected $fillable = [
        'name',
        'phone',
        'spin_uuid',
        'is_active',
    ];

    protected $hidden = [
        'remember_token',
    ];

    protected $casts = [
        'is_active' => 'boolean',
    ];

    public function spins(): HasMany
    {
        return $this->hasMany(Spin::class);
    }
}
