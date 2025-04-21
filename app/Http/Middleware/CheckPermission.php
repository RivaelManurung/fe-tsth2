<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CheckPermission
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request   $request
     * @param  \Closure                   $next
     * @param  string                     $permission    The permission slug you passed on the route
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function handle(Request $request, Closure $next, string $permission): Response
    {
        // Ambil permissions dari session
        $permissions = session('permissions', []);

        // Periksa apakah permission yang dibutuhkan ada di session
        if (!in_array($permission, $permissions)) {
            // Jika tidak ada, kembalikan error 403
            return response()->view('error.403', [], 403);
        }

        return $next($request);
    }

}
