<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;
use App\Models\SystemSetting;

class RoleMiddleware
{
    public function handle($request, Closure $next, $roles)
    {
        // Ensure user is logged in
        if (!Auth::check()) {
            return redirect()->route('login.form')
                ->withErrors(['login' => 'Please log in to continue.']);
        }

        $user = Auth::user();
        $allowedRoles = array_map('trim', explode('|', strtolower($roles)));
        $userRole = strtolower($user->role ?? '');

        // No role assigned — force logout
        if (!$userRole) {
            Auth::logout();
            return redirect()->route('login.form')
                ->withErrors(['role' => 'Your account has no assigned role.']);
        }

        // Role matches allowed roles — allow access
        if (in_array($userRole, $allowedRoles)) {
            return $next($request);
        }

        // Wrong role — redirect to their correct dashboard
        return $this->redirectBasedOnRole($userRole);
    }

    private function redirectBasedOnRole(string $role)
    {
        return match ($role) {
    'admin' => redirect()->route('dashboard.admin'),
    'staff' => redirect()->route('dashboard.staff'),
    'client' => redirect()->route('dashboard.client'),
    'super_admin' => redirect()->route('dashboard.superadmin'), // ✅ match route name
    default => abort(403, 'Unauthorized'),
};


if (SystemSetting::get('portal_status') === 'shutdown') {
    abort(503, 'The portal is temporarily closed by Super Admin.');
}

}

    }

  


