<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationException;
use App\Models\User;
use App\Mail\SendOtpMail;
use App\Helpers\SmsHelper;
use App\Models\StaffWorkSession;
use Carbon\Carbon;

class LoginController extends Controller
{
    public function showLoginForm()
    {
        return view('auth.login');
    }

    public function login(Request $request)
    {
        $request->validate([
            'identifier' => 'required|string',
            'password' => 'required|string',
            'role' => 'required|in:client,staff,admin,super_admin'
        ]);

        $identifier = $request->identifier;
        $role = $request->role;

        // ==========================================
        // 1️⃣ OPTIMIZED — Find User Quickly
        // ==========================================
        $user = User::where('role', $role)
            ->where(function ($q) use ($identifier) {
                if (filter_var($identifier, FILTER_VALIDATE_EMAIL)) {
                    $q->where('email', $identifier);
                } else {
                    $q->where('pension_number', $identifier)
                      ->orWhere('staff_id', $identifier);
                }
            })
            ->first();

        if (!$user) {
            throw ValidationException::withMessages([
                'identifier' => ['User not found with provided details.'],
            ]);
        }

        // ==========================================
        // 2️⃣ FAST PASSWORD CHECK
        // ==========================================
        if (!Auth::validate(['email' => $user->email, 'password' => $request->password])) {
            throw ValidationException::withMessages([
                'identifier' => ['Invalid credentials.'],
            ]);
        }

        if (!$user->is_active) {
            throw ValidationException::withMessages([
                'identifier' => ['Your account is inactive. Contact Admin.'],
            ]);
        }

        // ==========================================
        // 3️⃣ OTP GENERATION (INSTANT)
        // ==========================================
        $otp = random_int(100000, 999999);
        $expiresAt = now()->addMinutes(5);

        $user->update([
            'otp_code' => $otp,
            'otp_expires_at' => $expiresAt,
            'otp_attempts' => 0,
        ]);

        // ==========================================
        // 4️⃣ SEND OTP (NON-BLOCKING using try blocks)
        // ==========================================

        // EMAIL OTP
        dispatch(function () use ($user, $otp, $expiresAt) {
            try {
                \Mail::to($user->email)->queue(new SendOtpMail($otp, $expiresAt));
            } catch (\Throwable $e) {
                \Log::error("OTP Email Failed: " . $e->getMessage());
            }
        })->afterResponse(); // ⚡ Runs AFTER page load

        // SMS OTP
        if (!empty($user->phone_number)) {
            dispatch(function () use ($user, $otp) {
                try {
                    SmsHelper::send($user->phone_number, "Your ImperialVilla OTP is {$otp}. It expires in 5 minutes.");
                } catch (\Throwable $e) {
                    \Log::error("OTP SMS Failed: " . $e->getMessage());
                }
            })->afterResponse(); // ⚡ Also runs AFTER page load
        }

        // ==========================================
        // 5️⃣ SUPER FAST LOGIN GEOLOCATION (NO API CALL)
        // ==========================================
        try {
            $ip = $request->ip();

            // Skip geolocation for localhost
            if (!in_array($ip, ['127.0.0.1', '::1'])) {
                // Queue geolocation so it does NOT slow login
                dispatch(function () use ($user, $ip) {
                    try {
                        $response = @file_get_contents("https://ipapi.co/{$ip}/json/");
                        $details = $response ? json_decode($response) : null;

                        if ($user->client && $details) {
                            $user->client->update([
                                'city'      => $details->city ?? null,
                                'state'     => $details->region ?? null,
                                'latitude'  => $details->latitude ?? null,
                                'longitude' => $details->longitude ?? null,
                            ]);
                        }
                    } catch (\Throwable $e) {
                        \Log::error("Geolocation async failed: ".$e->getMessage());
                    }
                })->afterResponse();
            }

        } catch (\Throwable $e) {
            \Log::error("Geo Exception: ".$e->getMessage());
        }

        // ==========================================
        // 6️⃣ STORE IDENTIFIER FOR OTP PAGE
        // ==========================================
        session([
            'otp_email' => $user->email,
            'otp_role'  => $user->role,
        ]);

        return redirect()->route('otp.form')
            ->with('success', 'OTP sent. Enter it to complete login.');
    }

    // LOG STAFF LOGIN
    protected function authenticated($request, $user)
    {
        if ($user->role === 'staff') {
            StaffWorkSession::firstOrCreate(
                [
                    'staff_id'  => $user->id,
                    'work_date' => Carbon::now()->toDateString()
                ],
                [
                    'start_time' => Carbon::now()
                ]
            );
        }
    }

    // ==========================================
    // 7️⃣ LOGOUT (END WORK SESSION)
    // ==========================================
    public function logout(Request $request)
    {
        $user = auth()->user();

        if ($user && $user->role === 'staff') {

            $session = StaffWorkSession::where('staff_id', $user->id)
                ->where('work_date', Carbon::today()->toDateString())
                ->first();

            if ($session && !$session->end_time) {

                $session->end_time = Carbon::now();
                $session->hours_spent = round(
                    Carbon::parse($session->start_time)
                        ->diffInMinutes($session->end_time) / 60,
                    2
                );

                $session->save();
            }
        }

        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('login.form');
    }
}
