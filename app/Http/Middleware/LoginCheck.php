<?php
namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class LoginCheck
{
    public function handle(Request $request, Closure $next, $role)
    {
        if (auth()->check() && auth()->user()->role->id == $role) {
            return $next($request);
        }

        return redirect('/login')->with('error', 'Akses tidak diizinkan.');
    }
}
