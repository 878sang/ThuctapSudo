<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CheckRole
{
    /**
     * Handle an incoming request.
     *
     * @param  Closure(Request): (Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        if ($request->user() && $request->user()->role !== 'super_admin') {
            return redirect()->route('products.index')->with('error', 'Bạn không có quyền truy cập vào trang này!');
        }
        return $next($request);
    }
}
