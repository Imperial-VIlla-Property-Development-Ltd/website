@extends('layouts.app')
@section('title', 'Super Admin Login')

@section('content')
<div class="min-h-screen flex items-center justify-center bg-gradient-to-br from-gray-950 via-gray-900 to-gray-800 text-white p-6">
  <div class="w-full max-w-md bg-gray-900/80 backdrop-blur-lg border border-gray-700 rounded-2xl shadow-2xl p-8">

    {{-- Header --}}
    <div class="text-center mb-6">
      <h2 class="text-3xl font-bold text-green-400 tracking-wide">Super Admin Access</h2>
      <p class="text-gray-400 text-sm mt-1">Restricted zone — authorized users only</p>
      <div class="w-16 h-1 bg-green-400 mx-auto mt-3 rounded-full"></div>
    </div>

    {{-- Login Form --}}
    <form method="POST" action="{{ route('superadmin.login.post') }}" class="space-y-6">
      @csrf
      <meta name="csrf-token" content="{{ csrf_token() }}"> {{-- ✅ Ensures CSRF token is embedded --}}
      
      {{-- Flash Messages --}}
      @if(session('error'))
        <div class="p-3 text-red-400 bg-red-900/20 border border-red-800 rounded-md text-sm">
          ⚠️ {{ session('error') }}
        </div>
      @endif

      @if ($errors->any())
        <div class="p-3 text-red-400 bg-red-900/20 border border-red-800 rounded-md text-sm">
          <ul class="list-disc list-inside">
            @foreach ($errors->all() as $error)
              <li>{{ $error }}</li>
            @endforeach
          </ul>
        </div>
      @endif

      {{-- Email --}}
      <div>
        <label class="block text-sm text-gray-400 mb-2">Email Address</label>
        <input type="email" name="email" required
               placeholder="admin@example.com"
               class="w-full p-3 rounded-lg bg-gray-800 border border-gray-700 text-gray-200 focus:outline-none focus:ring-2 focus:ring-green-400 transition">
      </div>

      {{-- Password --}}
      <div>
        <label class="block text-sm text-gray-400 mb-2">Password</label>
        <input type="password" name="password" required
               placeholder="••••••••"
               class="w-full p-3 rounded-lg bg-gray-800 border border-gray-700 text-gray-200 focus:outline-none focus:ring-2 focus:ring-green-400 transition">
      </div>

      {{-- Login Button --}}
      <button type="submit"
        class="w-full py-2.5 bg-green-500 hover:bg-green-600 text-white font-semibold rounded-lg shadow-lg transition-transform transform hover:scale-[1.02]">
        🛡️ Login to Control Panel
      </button>
    </form>

    {{-- Footer --}}
    <div class="text-center mt-8 text-xs text-gray-500">
      © {{ now()->year }} ImperialVilla — Secure Admin Suite
    </div>
  </div>
</div>
@endsection
