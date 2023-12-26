<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
class AuthCheck
{
    public function handle(Request $request, Closure $next)
    {
        if (!Auth::check()) {
            // Nếu người dùng chưa đăng nhập, chuyển hướng đến trang đăng nhập
            return redirect()->route('login.admin'); // Điều hướng đến trang đăng nhập của bạn
        }

        return $next($request);
    }
}
