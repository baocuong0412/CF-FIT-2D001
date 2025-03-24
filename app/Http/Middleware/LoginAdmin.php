<?php

namespace App\Http\Middleware;

use App\Models\Admin;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class LoginAdmin
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        // dd(Auth::guard('admin')->check());
        if (!Auth::guard('admin')->check()) {
            return redirect()->route('admin.login.form')
                ->with('error', 'Vui lòng đăng nhập để truy cập trang quản trị.');
        }

        return $next($request);
    }
}
