<?php

namespace App\Http\Middleware;

use Illuminate\Auth\Middleware\Authenticate as Middleware;
use Illuminate\Http\Request;

class Authenticate extends Middleware
{
    /**
     * Get the path the user should be redirected to when they are not authenticated.
     */
    protected function redirectTo(Request $request): ?string
    {
        if (! $request->expectsJson()) {
            // Detect which guard is being used and redirect accordingly
            if ($request->is('client/*')) {
                return route('client.login');
            } elseif ($request->is('staff/*')) {
                return route('staff.login');
            } elseif ($request->is('admin/*')) {
                return route('admin.login');
            }

            // Default fallback if none match
            return route('client.login');
        }

        return null;
    }
}
