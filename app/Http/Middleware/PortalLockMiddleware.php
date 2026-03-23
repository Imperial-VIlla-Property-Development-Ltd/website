<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use App\Models\SystemSetting;

class PortalLockMiddleware
{
    public function handle(Request $request, Closure $next)
    {
        // Fetch current portal status (defaults to 'active' if missing)
        $portalStatus = SystemSetting::get('portal_status', 'active');

        // List of always-allowed routes for Super Admin
        $allowedSuperAdminRoutes = [
            'superadmin.login',
            'superadmin.login.post',
            'dashboard.superadmin',
            'superadmin.toggle.portal',
        ];

        // Allow verification page to be accessed even when portal is shutdown
if ($request->is('verify/*')) {
    return $next($request);
}


        // ✅ Always allow Super Admin routes or shutdown control routes
        if (
            $portalStatus === 'active' ||
            $this->isAllowedForSuperAdmin($request, $allowedSuperAdminRoutes)
        ) {
            return $next($request);
        }

        // ✅ If logged in as Super Admin, bypass shutdown entirely
        if (auth()->check() && auth()->user()->role === 'super_admin') {
            return $next($request);
        }

        // 🚫 If not super admin and portal is shutdown, log out and show maintenance page
        if (auth()->check()) {
            auth()->logout();
        }

        return response()->view('errors.maintenance', [], 503);
    }

    

    /**
     * Determine if this request should be allowed during shutdown.
     */
    private function isAllowedForSuperAdmin(Request $request, array $allowedRoutes): bool
    {
        $routeName = optional($request->route())->getName();
        $path = $request->path();

        return in_array($routeName, $allowedRoutes)
            || str_contains($path, 'super-admin')
            || str_contains($path, 'superadmin');
    }
}
