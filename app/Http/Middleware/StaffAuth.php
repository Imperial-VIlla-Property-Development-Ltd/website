<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;

class StaffAuth
{
    public function handle($request, Closure $next)
    {
        if (!Auth::guard('staff')->check()) {
            return redirect()->route('staff.login');
        }
        return $next($request);
    }
}
