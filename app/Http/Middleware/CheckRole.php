<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CheckRole
{
    /**
     * Handle an incoming request.
     */
    public function handle(Request $request, Closure $next, ...$roles): Response
    {
        $user = auth()->user();

        // Cek kalau user tidak punya relasi role
        if (!$user || !$user->role) {
            abort(403, 'Akses ditolak: Role tidak ditemukan.');
        }

        // Ambil nama role di tabel roles
        $userRole = $user->role->role ?? null;

        // Cek apakah role user sesuai
        if (!in_array($userRole, $roles)) {
            abort(403, 'Akses ditolak: Anda tidak memiliki izin.');
        }

        return $next($request);
    }
}
