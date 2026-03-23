@extends('layouts.auth')

@section('title', 'Proof of Registration')

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
<div class="min-h-screen bg-gray-100 dark:bg-gray-900 py-12 px-4">
  <div class="max-w-3xl mx-auto bg-white dark:bg-gray-800 rounded-2xl shadow-xl p-8 relative overflow-hidden">

    {{-- Decorative background ring --}}
    <div class="absolute inset-0 opacity-5 bg-gradient-to-r from-blue-600 via-indigo-500 to-purple-600 rounded-2xl"></div>

    {{-- Header --}}
    <div class="relative text-center mb-8">
      <h1 class="text-3xl font-bold text-blue-700 dark:text-blue-400">✅ Registration Complete</h1>
      <p class="text-gray-600 dark:text-gray-300 mt-2">
        Thank you for registering with <strong>ImperialVilla 25% Equity Processing Portal</strong>.
      </p>
    </div>

    {{-- Profile Section --}}
    <div class="relative flex flex-col sm:flex-row items-center sm:items-start sm:space-x-6 bg-gray-50 dark:bg-gray-700/40 p-5 rounded-xl mb-8 border border-gray-200 dark:border-gray-600">
      <img src="{{ $user->profile_photo ? asset('storage/' . $user->profile_photo) : 'https://ui-avatars.com/api/?name=' . urlencode($user->name) }}" 
           alt="Profile Photo" 
           class="w-24 h-24 rounded-full border-4 border-blue-600 shadow-md object-cover mb-4 sm:mb-0">

      <div class="flex-1 text-center sm:text-left">
        <h2 class="text-2xl font-semibold text-gray-800 dark:text-gray-100">{{ strtoupper($user->name) }}</h2>
        <p class="text-sm text-gray-500 dark:text-gray-400 mt-1">{{ $user->email }}</p>

        {{-- Correct registration date --}}
        <p class="text-xs text-gray-400 dark:text-gray-500 mt-1">
          Registered on {{ $client->created_at->format('d M, Y') }}
        </p>
      </div>
    </div>

    {{-- Detailed Info --}}
    <div class="relative border-y border-gray-200 dark:border-gray-700 py-6 mb-8">
      <h3 class="text-lg font-semibold text-gray-800 dark:text-gray-100 mb-4">📋 Registration Summary</h3>
      <div class="grid sm:grid-cols-2 gap-6 text-sm">

        <div>
          <p class="text-gray-500 dark:text-gray-400">Registration ID</p>
          <p class="font-semibold text-blue-600">{{ $client->registration_id }}</p>
        </div>

        <div>
          <p class="text-gray-500 dark:text-gray-400">Pension Number</p>
          {{-- FIXED: pension number comes from users table --}}
          <p class="font-semibold text-gray-800 dark:text-gray-100">{{ $user->pension_number ?? 'Not Assigned' }}</p>
        </div>

        <div>
          <p class="text-gray-500 dark:text-gray-400">PFA (Pension Fund Administrator)</p>
          <p class="font-semibold text-gray-800 dark:text-gray-100">{{ $client->pfa_selected ?? 'Not Selected' }}</p>
        </div>

        <div>
          <p class="text-gray-500 dark:text-gray-400">Registration Fee</p>
          @if($isPaid)
            <p class="font-semibold text-green-600">₦{{ number_format($client->fee_amount ?? 100000, 2) }} (Paid)</p>
          @else
            <p class="font-semibold text-red-500">Not Paid</p>
          @endif
        </div>

        <div>
          <p class="text-gray-500 dark:text-gray-400">Contact Number</p>
          <p class="font-semibold text-gray-800 dark:text-gray-100">{{ $client->phone_number }}</p>
        </div>

      </div>
    </div>

    {{-- QR Section --}}
    <div class="relative flex flex-col items-center mb-8">
      @php
       $verificationUrl = url('/verify/' . urlencode($client->registration_id));

      @endphp

      <div class="bg-white dark:bg-gray-700 p-4 rounded-lg shadow-inner">
        {!! QrCode::size(130)->generate($verificationUrl) !!}
      </div>

      <p class="text-xs text-gray-500 dark:text-gray-400 mt-3">
        Scan to verify registration: 
        <span class="text-blue-600">{{ $client->registration_id }}</span>
      </p>
    </div>

    {{-- Buttons --}}
    <div class="relative flex flex-wrap justify-center gap-4 mt-8">
      <a href="{{ route('pdf.registration-proof', $client->id) }}" 
         class="bg-blue-600 hover:bg-blue-700 text-white px-5 py-2.5 rounded-md shadow-md flex items-center space-x-2 text-sm transition-all">
        <span>📄</span><span>Download Proof</span>
      </a>

      <button onclick="window.print()" 
              class="bg-gray-700 hover:bg-gray-900 text-white px-5 py-2.5 rounded-md shadow-md flex items-center space-x-2 text-sm transition-all">
        <span>🖨️</span><span>Print</span>
      </button>

      @auth
        <a href="{{ route('dashboard.client') }}" 
           class="bg-green-600 hover:bg-green-700 text-white px-5 py-2.5 rounded-md shadow-md flex items-center space-x-2 text-sm transition-all">
          <span>🏠</span><span>Go to Dashboard</span>
        </a>
      @else
        <a href="{{ route('login.form') }}" 
           class="bg-yellow-500 hover:bg-yellow-600 text-white px-5 py-2.5 rounded-md shadow-md flex items-center space-x-2 text-sm transition-all">
          <span>🔐</span><span>Login to Portal</span>
        </a>
      @endauth
    </div>

    {{-- Footer --}}
    <div class="relative mt-10 text-center text-xs text-gray-400 dark:text-gray-500">
      <p>ImperialVilla 25% Equity Processing Portal &copy; {{ now()->year }} • All Rights Reserved</p>
    </div>

  </div>
</div>
@endsection
