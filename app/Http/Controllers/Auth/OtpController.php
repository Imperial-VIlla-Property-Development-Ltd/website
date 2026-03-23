<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use App\Mail\ClientLoginAlertMail;

class OtpController extends Controller
{
    public function showForm()
    {
        $email = session('otp_email');

        if (!$email) {
            return redirect()->route('login.form')
                ->with('error', 'Please login first.');
        }

        return view('auth.otp', ['email' => $email]);
    }

    public function verify(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'otp'   => 'required|digits:6'
        ]);

        // =====================================================
        // 🔍 1. Retrieve user ONLY once (fast)
        // =====================================================
        $user = \App\Models\User::where('email', $request->email)->first();

        if (!$user) {
            return back()->withErrors(['email' => 'User not found.']);
        }

        // =====================================================
        // 🚫 2. Too many attempts
        // =====================================================
        if (($user->otp_attempts ?? 0) >= 5) {
            return back()->with('error', 'Too many attempts. Try again later.');
        }

        $expiresAt = $user->otp_expires_at;

        // =====================================================
        // ⏳ 3. Check expiration
        // =====================================================
        if (!$user->otp_code || !$expiresAt || now()->gt($expiresAt)) {
            $user->update([
                'otp_code'        => null,
                'otp_expires_at'  => null,
                'otp_attempts'    => 0
            ]);

            return back()->with('error', 'OTP expired. Please login again.');
        }

        // =====================================================
        // ❌ 4. Wrong OTP (fast check)
        // =====================================================
        if ((string)$user->otp_code !== (string)$request->otp) {
            $user->increment('otp_attempts');
            return back()->withErrors(['otp' => 'Invalid OTP.']);
        }

        // =====================================================
        // ✅ 5. OTP Valid — Clear OTP cleanly
        // =====================================================
        $user->update([
            'otp_code'        => null,
            'otp_expires_at'  => null,
            'otp_attempts'    => 0,
        ]);

        // =====================================================
        // 🔐 6. LOGIN user instantly
        // =====================================================
        Auth::loginUsingId($user->id);

        // =====================================================
        // 📧 7. Send login alert (ASYNC → no delay)
        // =====================================================
        dispatch(function () use ($user) {
            try {
                \Mail::to($user->email)->queue(new ClientLoginAlertMail($user));
            } catch (\Throwable $e) {
                Log::error("Login alert email failed: " . $e->getMessage());
            }
        })->afterResponse();

        // =====================================================
        // 🎯 8. Redirect based on role
        // =====================================================
        return match ($user->role) {
            'client'      => redirect()->route('dashboard.client'),
            'staff'       => redirect()->route('dashboard.staff'),
            'admin'       => redirect()->route('dashboard.admin'),
            'super_admin' => redirect()->route('dashboard.superadmin'),
            default       => redirect()->route('home'),
        };
    }

    // ===================================================================
    // 🔁 RESEND OTP — Fully optimized, non-blocking, instant UI feedback
    // ===================================================================
    public function resend(Request $request)
    {
        $email = session('otp_email') ?: $request->email;

        $user = \App\Models\User::where('email', $email)->firstOrFail();

        $otp = random_int(100000, 999999);
        $expiresAt = now()->addMinutes(5);

        $user->update([
            'otp_code'       => (string)$otp,
            'otp_expires_at' => $expiresAt,
            'otp_attempts'   => 0
        ]);

        // EMAIL (async)
        dispatch(function () use ($user, $otp, $expiresAt) {
            try {
                \Mail::to($user->email)->queue(new \App\Mail\SendOtpMail($otp, $expiresAt));
            } catch (\Throwable $e) {
                Log::error('OTP resend email failed: '.$e->getMessage());
            }
        })->afterResponse();

        // SMS (async)
        if (!empty($user->phone_number)) {
            dispatch(function () use ($user, $otp) {
                try {
                    \App\Helpers\SmsHelper::send($user->phone_number, "Your new OTP is {$otp}. It expires in 5 minutes.");
                } catch (\Throwable $e) {
                    Log::error('OTP resend SMS failed: '.$e->getMessage());
                }
            })->afterResponse();
        }

        return back()->with('success', 'A new OTP has been sent.');
    }
}
