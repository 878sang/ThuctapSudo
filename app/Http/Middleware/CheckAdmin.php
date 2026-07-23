<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class CheckAdmin
{
    /**
     * Handle an incoming request.
     */
    public function handle(Request $request, Closure $next): Response
    {
        if (!Auth::check() || !in_array(Auth::user()->role, ['super_admin', 'staff'])) {
            return redirect()->route('admin.login')->with('error', 'Bạn không có quyền truy cập vào trang quản trị!');
        }

        return $next($request);
    }
}
