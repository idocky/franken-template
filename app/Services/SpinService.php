<?php

namespace App\Services;

use App\Models\Spin;
use App\Models\User;

class SpinService
{
    public function spin(User $user): Spin
    {
        return $this->spinWithNumber($user, random_int(1, 1000));
    }

    public function spinWithNumber(User $user, int $randomNumber): Spin
    {
        $isWin = $randomNumber % 2 === 0;
        $points = $isWin
            ? $this->calculatePoints($randomNumber)
            : 0;

        return $user->spins()->create([
            'result' => $isWin ? 'Win' : 'Lose',
            'points' => $points,
            'random_number' => $randomNumber,
        ]);
    }

    public function history(User $user, int $limit = 3)
    {
        return $user->spins()
            ->latest('id')
            ->take($limit)
            ->get();
    }

    private function calculatePoints(int $randomNumber): float
    {
        return match (true) {
            $randomNumber > 900 => $randomNumber * 0.7,
            $randomNumber > 600 => $randomNumber * 0.5,
            $randomNumber > 300 => $randomNumber * 0.3,
            default => $randomNumber * 0.1,
        };
    }
}
