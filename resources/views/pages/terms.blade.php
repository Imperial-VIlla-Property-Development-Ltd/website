@extends('layouts.app')

@section('title', 'Terms & Conditions — ImperialVilla')

@section('content')
<!-- HERO SECTION -->
<section class="page-hero text-center text-white py-5 position-relative" style="background: url('{{ asset('images/service8.png') }}') center/cover no-repeat; padding: 100px 0;">
  <div class="position-absolute top-0 start-0 w-100 h-100" style="background: linear-gradient(rgba(11, 44, 77, 0.9), rgba(11, 44, 77, 0.8));"></div>
  <div class="container position-relative z-2">
    <h1 class="display-4 fw-bold text-white">Terms and Conditions</h1>
    <p class="lead text-light mx-auto mt-3" style="max-width: 700px; font-weight:300;">
      Please read these terms carefully before engaging with our services.
    </p>
  </div>
</section>

<!-- CONTENT SECTION -->
<section class="py-6 bg-white">
  <div class="container py-4">
    <div class="row justify-content-center">
      <div class="col-lg-10">
        <div class="card border-0 shadow-sm rounded-4 p-4 p-md-5 bg-light">
          
          <h3 class="fw-bold text-primary mb-3">1. Introduction</h3>
          <p class="text-secondary lh-lg mb-4">Welcome to Imperial Villa Property Limited. These Terms and Conditions govern your use of our website and services, including property development, 25% RSA Equity Mortgage processes, and pensioner equipment distribution. By accessing our services, you agree to comply with these terms in full.</p>

          <h3 class="fw-bold text-primary mb-3">2. 25% Equity Mortgage & Pension Facilitation</h3>
          <p class="text-secondary lh-lg mb-4">Our facilitation of the 25% RSA Equity Mortgage is performed in accordance with PENCOM regulations. ImperialVilla acts as a facilitator and developer; final approval depends strictly on the Pension Fund Administrator (PFA) and regulatory compliance. We guarantee full transparency but cannot override legal state or federal pension laws.</p>

          <h3 class="fw-bold text-primary mb-3">3. Property Transactions</h3>
          <p class="text-secondary lh-lg mb-4">All property reservations require a signed agreement. Payments are strictly non-refundable unless explicitly stated otherwise in a formalized legal contract between ImperialVilla and the client. Development timelines are estimated and inherently subject to market conditions, material availability, and government regulations.</p>

          <h3 class="fw-bold text-primary mb-3">4. Limitation of Liability</h3>
          <p class="text-secondary lh-lg mb-4">Imperial Villa Property Limited will not be held liable for delays or failures in performance resulting from causes beyond our reasonable control, including but not limited to acts of God, governmental actions, or third-party banking delays.</p>

          <h3 class="fw-bold text-primary mb-3">5. Governing Law</h3>
          <p class="text-secondary lh-lg mb-5">These terms shall be governed by and construed in accordance with the laws of the Federal Republic of Nigeria. Our headquarters are legally bound in Gombe, Nigeria, with full national operating authority.</p>

          <div class="alert alert-primary mt-3" role="alert">
            <i class="fas fa-info-circle me-2"></i> If you have any further legal inquiries, please reach out directly via our <a href="{{ route('contact') }}" class="fw-bold text-primary">Contact Page</a>.
          </div>
        </div>
      </div>
    </div>
  </div>
</section>
@endsection
