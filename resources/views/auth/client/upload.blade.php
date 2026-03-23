@extends('layouts.auth')

@section('title', 'Upload Documents')

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


    /* Enhance background overlay inside auth layout */
    .upload-wrapper {
        position: relative;
        z-index: 5;
    }

    h2 {
        color: #fff;
        font-size: 26px;
        font-weight: 800;
        text-align: center;
        margin-bottom: 6px;
    }

    .subtitle {
        color: #0D0D0EFF;
        text-align: center;
        margin-bottom: 25px;
        font-size: 14px;
    }

    /* Clean 2-column grid */
    .form-grid {
        display: grid;
        grid-template-columns: repeat(2, 1fr);
        gap: 22px 32px;
    }

    label {
        font-weight: 600;
        color: #fff;
        margin-bottom: 6px;
        display: block;
        font-size: 14px;
    }

    .input-file {
        width: 100%;
        padding: 12px;
        background: #B8A6A6EF;
        border-radius: 10px;
        border: 1px solid #cbd5e1;
        font-size: 14px;
        transition: .2s;
    }

    .input-file:hover {
        border-color: #3b82f6;
        box-shadow: 0 0 6px rgba(59, 130, 246, .35);
        color: black;
    }

    .submit-btn {
        grid-column: span 2;
        background: linear-gradient(to right, #2563eb, #1d4ed8);
        color: #fff;
        border-radius: 12px;
        padding: 14px;
        font-size: 16px;
        font-weight: 700;
        width: 100%;
        margin-top: 10px;
        transition: .25s ease-in-out;
    }

    .submit-btn:hover {
        transform: translateY(-2px);
        background: linear-gradient(to right, #1d4ed8, #1e3a8a);
    }
</style>

<div class="upload-wrapper">

    {{-- Progress Component --}}
    <x-onboarding-progress step="5" />

    <h2>Step 4 of 4 — Upload Required Documents</h2>
    <p class="subtitle">Upload each document in the correct category below.</p>

    <form method="POST"
          action="{{ route('register.client.upload.post') }}"
          enctype="multipart/form-data"
          class="form-grid">

        @csrf

        <div>
            <label>PFA Form (Filled)</label>
            <input type="file" name="pfa_forms" class="input-file" required>
        </div>

        <div>
            <label>Introductory Letter</label>
            <input type="file" name="introductory_letter" class="input-file" required>
        </div>

        <div>
            <label>NIN Slip</label>
            <input type="file" name="nin_slip" class="input-file" required>
        </div>

        <div>
            <label>Appointment Letter</label>
            <input type="file" name="appointment_letter" class="input-file" required>
        </div>

        <div>
            <label>Office ID Card</label>
            <input type="file" name="office_id" class="input-file" required>
        </div>

        <div>
            <label>Birth Certificate / Declaration</label>
            <input type="file" name="birth_certificate" class="input-file" required>
        </div>

        <div>
            <label>Handwritten Letter</label>
            <input type="file" name="handwritten_letter" class="input-file" required>
        </div>

        <div>
            <label>Bvn Proof</label>
            <input type="file" name="bvn_proof" class="input-file" required>
        </div>

        <div>
            <label>RSA Statement</label>
            <input type="file" name="rsa_statement" class="input-file" required>
        </div>

        <div>
            <label>Undertaking</label>
            <input type="file" name="undertaking" class="input-file" required>
        </div>

        <button class="submit-btn">
            Submit Registration
        </button>

    </form>

</div>

@endsection
