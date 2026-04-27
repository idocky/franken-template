<?php

namespace App\Services;

use App\Models\User;
use Illuminate\Support\Str;

class UserService
{
    public function register(array $data): User
    {
        return User::create([
            'name' => $data['name'],
            'phone' => $data['phone'],
            'spin_uuid' => Str::uuid(),
            'is_active' => true,
        ]);
    }

    public function regenerateSpinLink(User $user): User
    {
        $user->update([
            'spin_uuid' => Str::uuid(),
        ]);

        return $user->refresh();
    }

    public function deactivate(User $user): User
    {
        $user->update([
            'is_active' => false,
        ]);

        return $user->refresh();
    }
}
