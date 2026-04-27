<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Services\SpinService;
use App\Services\UserService;

class SpinController extends Controller
{
    public function __construct(
        private SpinService $spinService,
        private UserService $userService,
    ) {}

    public function index(string $uuid)
    {
        $user = $this->findUser($uuid);

        return view('spins.index', [
            'user' => $user,
            'latestSpin' => $user->spins()->latest('id')->first(),
        ]);
    }

    public function history(string $uuid)
    {
        $user = $this->findUser($uuid);

        return view('spins.history', [
            'user' => $user,
            'history' => $this->spinService->history($user),
        ]);
    }

    public function store(string $uuid)
    {
        $user = $this->findUser($uuid);

        $this->spinService->spin($user);

        return redirect()->route('spins.index', ['uuid' => $user->spin_uuid]);
    }

    public function regenerate(string $uuid)
    {
        $user = $this->findUser($uuid);
        $user = $this->userService->regenerateSpinLink($user);

        return redirect()->route('spins.index', $user->spin_uuid);
    }

    public function deactivate(string $uuid)
    {
        $user = $this->findUser($uuid);
        $this->userService->deactivate($user);

        return redirect()->route('home');
    }

    private function findUser(string $uuid): User
    {
        return User::query()
            ->where('spin_uuid', $uuid)
            ->firstOrFail();
    }
}
