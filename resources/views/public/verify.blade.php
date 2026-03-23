@extends('layouts.auth')

@section('title', 'Verify Registration')

@section('content')

<style>
    body {
        background: url('/images/bg.png') no-repeat center center fixed;
        background-size: cover;
    }
    .overlay {
        position: fixed;
        top:0; left:0;
        width:100%; height:100%;
        background: rgba(0,0,0,0.45);
        z-index:0;
    }
    .card-container {
        position: relative;
        z-index: 10;
        width: 100%;
        max-width: 420px;
    }

    /* ID Card Style */
    .id-card {
        background: linear-gradient(135deg, #ffffff, #f4f8ff);
        border-radius: 20px;
        padding: 35px 25px;
        box-shadow: 0 10px 35px rgba(0,0,0,0.25);
        text-align: center;
        border: 3px solid #2563eb;
        position: relative;
        overflow: hidden;
    }

    .id-card::before {
        content: "";
        position: absolute;
        top: -40px;
        right: -40px;
        width: 160px;
        height: 160px;
        background: rgba(37,99,235,0.15);
        border-radius: 50%;
    }

    .id-card::after {
        content: "";
        position: absolute;
        bottom: -40px;
        left: -40px;
        width: 160px;
        height: 160px;
        background: rgba(37,99,235,0.15);
        border-radius: 50%;
    }

    .profile-img {
        width: 130px;
        height: 130px;
        border-radius: 50%;
        object-fit: cover;
        border: 5px solid #2563eb;
        box-shadow: 0 6px 16px rgba(0,0,0,0.25);
        margin-bottom: 15px;
    }

    .verified-badge {
        display: inline-flex;
        align-items: center;
        background: #d1fae5;
        padding: 8px 16px;
        border-radius: 30px;
        color: #065f46;
        font-weight: 700;
        font-size: 14px;
        margin-top: 15px;
    }

    .verified-badge svg {
        width: 18px;
        height: 18px;
        margin-right: 6px;
        color: #059669;
    }

    .info-label {
        font-size: 12px;
        text-transform: uppercase;
        letter-spacing: 1px;
        color: #6b7280;
        margin-top: 15px;
    }

    .info-value {
        font-size: 18px;
        font-weight: 700;
        color: #1f2937;
        margin-top: 3px;
    }
</style>

<div class="overlay"></div>

<div class="min-h-screen flex items-center justify-center p-6">

    <div class="card-container">

        {{-- Digital ID Card --}}
        <div class="id-card">

            {{-- Logo --}}
            <img src="{{ asset('images/logo5.webp') }}" class="mx-auto mb-4 w-20" alt="Logo">

            {{-- Profile Photo --}}
            <img 
                src="{{ $client->user->profile_photo 
                        ? asset('storage/'.$client->user->profile_photo) 
                        : asset('default-avatar.png') }}"
                alt="Client Photo"
                class="profile-img"
            >

            {{-- Client Name --}}
            <h2 class="text-2xl font-bold text-gray-800 mt-3">
                {{ strtoupper($client->firstname.' '.$client->lastname) }}
            </h2>

            {{-- Pension Number --}}
            <div class="info-label">Pension Number</div>
            <div class="info-value">{{ $client->user->pension_number ?? 'N/A' }}</div>

            {{-- ID --}}
            <div class="info-label">Registration ID</div>
            <div class="info-value">{{ $client->registration_id ?? 'Not Selected' }}</div>

            <div class="info-label">PFA</div>
            <div class="info-value">{{ $client->pfa_selected }}</div>


            {{-- Verified Badge --}}
            <div class="verified-badge mt-5">
                <svg xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 20 20">
                    <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-7.25 7.25a1 1 0 01-1.414 0l-3.25-3.25a1 1 0 111.414-1.414L8.5 11.086l6.543-6.543a1 1 0 011.664.75z" clip-rule="evenodd"/>
                </svg>
                Verified Client
            </div>
        </div>

        {{-- Footer --}}
        <p class="text-xs text-gray-300 text-center mt-6">
            ImperialVilla Pension Processing Portal © {{ now()->year }}
        </p>

    </div>

</div>

@endsection
