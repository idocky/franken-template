<?php

namespace App\Http\Controllers;

use App\Http\Requests\Users\RegisterUserRequest;
use App\Services\UserService;

class UserController extends Controller
{
    public function __construct(private UserService $userService) {}

    public function register(RegisterUserRequest $request)
    {
        $validated = $request->validated();

        $user = $this->userService->register($validated);

        return redirect()->route('spins.index', $user->spin_uuid);
    }
}
