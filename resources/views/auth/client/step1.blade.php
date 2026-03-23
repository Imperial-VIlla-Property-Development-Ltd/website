@extends('layouts.app')
@section('title','Client Registration - Step 1')

@section('content')

<style>
    .reg-bg {
        background: url('/images/bg.png') no-repeat center center fixed;
        background-size: cover;
    }
    .reg-overlay {
        background: rgba(255, 255, 255, 0.85);
        backdrop-filter: blur(3px);
    }
    .input-field {
        border: 1px solid #cfd8dc;
        padding: 12px;
        border-radius: 8px;
        background: #f8f9fb;
        transition: 0.2s;
    }
    .input-field:focus {
        border-color: #2563eb;
        background: #fff;
        box-shadow: 0 0 0 3px rgba(37,99,235,0.15);
        outline: none;
    }
</style>

<div class="min-h-screen reg-bg flex items-center justify-center p-6">
    <div class="max-w-2xl w-full reg-overlay p-8 rounded-2xl shadow-xl">

        {{-- Progress Indicator --}}
        <x-onboarding-progress step="1" />

        {{-- Title --}}
        <h2 class="text-2xl font-bold text-gray-800 mb-6 text-center">
            👤 Client Registration — Biodata
        </h2>

        {{-- Form --}}
        <form action="{{ route('register.client.step1.post') }}" method="POST" enctype="multipart/form-data">
            @csrf

            <div class="grid grid-cols-1 md:grid-cols-2 gap-5">

                {{-- First Name --}}
                <div>
                    <label class="text-sm font-medium text-gray-600">First Name</label>
                    <input name="firstname" class="input-field w-full" placeholder="Enter first name" required>
                </div>

                {{-- Middle Name --}}
                <div>
                    <label class="text-sm font-medium text-gray-600">Middle Name</label>
                    <input name="middlename" class="input-field w-full" placeholder="(Optional)">
                </div>

                {{-- Last Name --}}
                <div>
                    <label class="text-sm font-medium text-gray-600">Last Name</label>
                    <input name="lastname" class="input-field w-full" placeholder="Enter last name" required>
                </div>

                {{-- Email --}}
                <div>
                    <label class="text-sm font-medium text-gray-600">Email Address</label>
                    <input name="email" type="email" class="input-field w-full" placeholder="example@email.com" required>
                </div>

                {{-- Phone --}}
                <div>
                    <label class="text-sm font-medium text-gray-600">Phone Number</label>
                    <input name="phone_number" class="input-field w-full" placeholder="Enter phone" required>
                </div>

                {{-- Pension Number --}}
                <div>
                    <label class="text-sm font-medium text-gray-600">Pension Number</label>
                    <input name="pension_number" class="input-field w-full" placeholder="PEN000000000000 " require>
                </div>

                {{-- Address --}}
                <div class="md:col-span-2">
                    <label class="text-sm font-medium text-gray-600">Residential Address</label>
                    <input name="address" class="input-field w-full" placeholder="Enter full residential address" required>
                </div>

                {{-- Profile Photo --}}
                <div class="md:col-span-2">
                    <label class="text-sm font-medium text-gray-600">Profile Photo</label>
                    <input type="file" name="profile_photo" class="input-field w-full bg-white">
                </div>

                {{-- Password --}}
                <div>
                    <label class="text-sm font-medium text-gray-600">Password</label>
                    <input name="password" type="password" class="input-field w-full" placeholder="Create password" required>
                </div>

                {{-- Confirm Password --}}
                <div>
                    <label class="text-sm font-medium text-gray-600">Confirm Password</label>
                    <input name="password_confirmation" type="password" class="input-field w-full" placeholder="Confirm password" required>
                </div>

            </div>

            {{-- Submit --}}
            <div class="mt-6 text-center">
                <button class="w-full bg-blue-600 hover:bg-blue-700 text-white font-semibold py-3 rounded-xl shadow-md transition duration-200">
                    Continue →
                </button>
            </div>

        </form>
    </div>
</div>

@endsection
