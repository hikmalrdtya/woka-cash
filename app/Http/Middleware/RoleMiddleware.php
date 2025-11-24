<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class RoleMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next, ...$roles): Response
    {
        $user = Auth::user();
        if(!$user){
            return redirect()->route("login");
        }
        if ($user->role === 'admin') {
            return $next($request);
        }
        if (!in_array($user->role, $roles)) {
            abort(403,'Akses ditolak, Anda tidak bisa mengakses halaman ini');
        }
        return $next($request);
    }
}
