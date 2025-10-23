<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class RoleMiddleware
{
    public function handle(Request $request, Closure $next, string $role)
    {
        if (! Auth::check()) {
            return redirect()->route('login');
        }

        $user = Auth::user();   

        // Cek role & (opsional) is_active jika ada
        if ($user->role !== $role) {
            abort(403, 'Akses ditolak.');
        }

        return $next($request);
    }
}
