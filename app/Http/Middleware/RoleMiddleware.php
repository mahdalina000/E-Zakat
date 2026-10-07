<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class RoleMiddleware
{
    public function handle(Request $request, Closure $next, string ...$roles): Response
    {
        $user = $request->user();

        if (! $user) {
            return redirect()->route('login');
        }

        // 'admin' matches both admin_baznas & admin_upz
        $allowed = false;
        foreach ($roles as $role) {
            if ($role === 'admin' && $user->isAdmin()) {
                $allowed = true;
                break;
            }
            if ($user->role === $role) {
                $allowed = true;
                break;
            }
        }

        if (! $allowed) {
            abort(403, 'Akses ditolak. Role Anda tidak memiliki izin untuk halaman ini.');
        }

        return $next($request);
    }
}
