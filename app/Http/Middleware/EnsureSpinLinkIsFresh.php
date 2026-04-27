<?php

namespace App\Http\Middleware;

use App\Models\User;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class EnsureSpinLinkIsFresh
{
    public function handle(Request $request, Closure $next): Response
    {
        $uuid = $request->route('uuid');

        $user = User::query()
            ->where('spin_uuid', $uuid)
            ->first();

        if (! $user) {
            abort(404);
        }

        if ($user->created_at->lte(now()->subDays(7))) {
            return redirect()->route('home');
        }

        if (! $user->is_active) {
            return redirect()->route('home');
        }

        return $next($request);
    }
}
