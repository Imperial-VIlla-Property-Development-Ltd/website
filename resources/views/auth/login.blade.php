@extends('layouts.app')
@section('title','Login')

@section('content')

<style>
    body {
        background: url('/images/bg.png') no-repeat center center fixed !important;
        background-size: cover !important;
    }
    body::before {
        content: "";
        position: fixed;
        top: 0; left: 0;
        width: 100%; height: 100%;
        background: rgba(0,0,0,0.55);
        z-index: 0;
    }

    .relative, .content, form, .min-h-screen, .container {
        position: relative;
        z-index: 10;
    }
</style>

{{-- Remove the previous blue gradient --}}
<div class="min-h-screen flex items-center justify-center p-6">

    {{-- 💎 White Card Wrapper --}}
    <<div class="w-full max-w-md bg-white dark:bg-gray-900 rounded-2xl shadow-xl p-8 border border-gray-200 dark:border-gray-700">

        {{-- Header --}}
        <div class="text-center mb-6">
            <img src="{{ asset('images/logo5.webp')}}" alt="ImperialVilla Logo" class="w-20 mx-auto mb-3">
            <h2 class="text-2xl font-bold text-blue-700 dark:text-blue-400">Welcome Back</h2>
            <p class="text-sm text-gray-500 dark:text-gray-400">Log in to access your dashboard</p>
        </div>

        {{-- Login Form --}}
        <form action="{{ route('login') }}" method="POST" class="space-y-5">
            @csrf

            {{-- Role --}}
            <div>
                <label class="block mb-2 text-sm font-medium text-gray-700 dark:text-gray-300">Select Role</label>
                <select name="role"
                    class="w-full border border-gray-300 dark:border-gray-700 p-3 rounded-lg bg-gray-50 dark:bg-gray-800 text-gray-800 dark:text-gray-100 focus:ring-2 focus:ring-blue-500 transition">
                    <option value="client">Client</option>
                    <option value="staff">Staff</option>
                    <option value="admin">Admin</option>
                </select>
            </div>

            {{-- Identifier --}}
            <div>
                <label class="block mb-2 text-sm font-medium text-gray-700 dark:text-gray-300">Email / Pension No / Staff ID</label>
                <input name="identifier"
                    placeholder="Enter your login ID"
                    class="w-full border border-gray-300 dark:border-gray-700 p-3 rounded-lg bg-gray-50 dark:bg-gray-800 text-gray-800 dark:text-gray-100 focus:ring-2 focus:ring-blue-500 transition"
                    required>
            </div>

            {{-- Password --}}
            <div>
                <label class="block mb-2 text-sm font-medium text-gray-700 dark:text-gray-300">Password</label>
                <input name="password" type="password"
                    placeholder="••••••••"
                    class="w-full border border-gray-300 dark:border-gray-700 p-3 rounded-lg bg-gray-50 dark:bg-gray-800 text-gray-800 dark:text-gray-100 focus:ring-2 focus:ring-blue-500 transition"
                    required>
            </div>

            {{-- Submit --}}
            <button class="w-full bg-blue-600 hover:bg-blue-700 text-white font-semibold py-2.5 rounded-lg shadow-md transition transform hover:scale-[1.02]">
                🔐 Login
            </button>
        </form>

        {{-- Footer --}}
        <div class="mt-6 text-center text-sm">
            <p class="text-gray-500 dark:text-gray-400">Don’t have an account?</p>
            <a href="{{ route('register.client.step1') }}" class="text-blue-600 dark:text-blue-400 hover:underline font-medium">
                Register as Client
            </a>
        </div>

        <div class="text-center mt-8 text-xs text-gray-400 dark:text-gray-500">
            ImperialVilla Portal © {{ now()->year }}
        </div>

    </div>
</div>

@endsection
