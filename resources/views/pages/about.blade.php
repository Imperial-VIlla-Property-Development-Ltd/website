@extends('layouts.app')

@section('title', 'About Us — ImperialVilla')

@section('content')
<!-- HERO SECTION -->
<section class="page-hero text-center text-white py-6" style="background: linear-gradient(rgba(11, 44, 77, 0.8), rgba(11, 44, 77, 0.8)), url('{{ asset('images/service1.jpeg') }}') center/cover no-repeat; padding: 100px 0;">
  <div class="container position-relative z-2">
    <h1 class="display-4 fw-bold animate__animated animate__fadeInDown">About ImperialVilla</h1>
    <p class="lead animate__animated animate__fadeInUp animate__delay-1s mx-auto mt-3" style="max-width: 700px;">
      Empowering communities through premium property development and facilitating seamless pension access.
    </p>
  </div>
</section>

<!-- WHO WE ARE -->
<section class="py-5 bg-white">
  <div class="container py-5">
    <div class="row align-items-center g-5">
      <div class="col-md-6" data-aos="fade-right">
        <img src="{{ asset('images/service2.jpeg') }}" alt="About Us" class="img-fluid rounded-4 shadow-lg border border-5 border-white">
      </div>
      <div class="col-md-6" data-aos="fade-left">
        <span class="text-uppercase fw-bold text-success mb-2 d-block tracking-wide">Our Story</span>
        <h2 class="display-6 fw-bold mb-4 text-primary">Building Trust. Delivering Value.</h2>
        <p class="text-secondary lh-lg fs-5">Imperial Villa Property Limited has been a cornerstone of trust in the real estate sector. Our mission goes beyond building structures; we construct security, stability, and futures for generations.</p>
        <p class="text-secondary lh-lg fs-5">Whether developing state-of-the-art residential estates or assisting hardworking pensioners to access their well-deserved benefits, transparency and excellence guide our every step.</p>
        <ul class="list-unstyled mt-4 fs-5 text-secondary border-start border-3 border-success ps-4 py-2">
          <li class="mb-3"><i class="fas fa-check-circle text-success me-3"></i> Uncompromising Quality Standards</li>
          <li class="mb-3"><i class="fas fa-check-circle text-success me-3"></i> Client-Centric Property Approaches</li>
          <li class="mb-3"><i class="fas fa-check-circle text-success me-3"></i> Extensive Document Consultation Services</li>
        </ul>
      </div>
    </div>
  </div>
</section>
@endsection
