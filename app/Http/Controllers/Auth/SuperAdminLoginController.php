<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class SuperAdminLoginController extends Controller
{
    public function showLoginForm()
    {
        return view('auth.super-admin-login');
    }

    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email' => 'required|email',
            'password' => 'required|string',
        ]);

        if (Auth::attempt(array_merge($credentials, ['role' => 'super_admin']))) {
            $request->session()->regenerate();
            return redirect()->route('dashboard.superadmin')->with('success', 'Welcome Super Admin!');
        }

        return back()->withErrors([
            'email' => 'Invalid Super Admin credentials.',
        ]);
    }
}
