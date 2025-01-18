<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CheckRole
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @param  mixed  ...$roles
     * @return mixed
     */
    public function handle(Request $request, Closure $next, ...$roles)
    {
        // Memeriksa apakah user sudah login
        if (!Auth::check()) {
            return redirect('/login'); // Arahkan ke halaman login jika belum login
        }

        // Mendapatkan peran user
        $userRole = Auth::user()->role;

        // Memeriksa apakah peran user cocok dengan daftar role yang diizinkan
        if (in_array($userRole, $roles)) {
            return $next($request);
        }

        // Jika role tidak cocok
        if ($request->expectsJson()) {
            return response()->json(['message' => 'Forbidden'], 403);
        }

        return abort(403, 'Akses ditolak'); // Tampilkan error 403
    }
}
