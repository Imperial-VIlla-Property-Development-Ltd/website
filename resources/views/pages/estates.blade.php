@extends('layouts.app')

@section('title', 'Our Estates — ImperialVilla')

@section('content')
<link href="https://unpkg.com/aos@2.3.4/dist/aos.css" rel="stylesheet">
<style>
/* Portfolio Cards */
.estate-card { border-radius: 20px; overflow: hidden; transition: all 0.4s cubic-bezier(0.175, 0.885, 0.32, 1.275); }
.estate-card:hover { transform: translateY(-10px); box-shadow: 0 20px 40px rgba(0,0,0,0.15) !important; }
.estate-img-wrap { overflow: hidden; position: relative; height: 280px; }
.estate-img-wrap img { transition: all 0.7s ease; object-fit: cover; width: 100%; height: 100%; }
.estate-card:hover .estate-img-wrap img { transform: scale(1.1) rotate(1deg); }
.status-tag { position: absolute; top: 20px; right: 20px; background: var(--secondary-color); color: #fff; padding: 6px 18px; border-radius: 30px; font-weight: 700; font-size: 0.9rem; z-index: 2; box-shadow: 0 4px 15px rgba(0,0,0,0.2); letter-spacing: 0.5px; }
</style>

<!-- HERO SECTION -->
<section class="page-hero text-center text-white py-6 position-relative" style="background: url('{{ asset('images/service3.jpeg') }}') center/cover no-repeat; padding: 120px 0; background-attachment: fixed;">
  <div class="position-absolute top-0 start-0 w-100 h-100" style="background: linear-gradient(rgba(11, 44, 77, 0.9), rgba(11, 44, 77, 0.75));"></div>
  <div class="container position-relative z-2">
    <h1 class="display-3 fw-bold animate__animated animate__fadeInDown text-white">Our Premium Estates</h1>
    <p class="lead animate__animated animate__fadeInUp animate__delay-1s mx-auto mt-4 fs-4 text-light" style="max-width: 800px; font-weight:300;">
      Discover exclusive properties meticulously designed for modern luxury, absolute security, and unbeatable ROI.
    </p>
  </div>
</section>

<!-- ESTATES GRID -->
<section class="py-6 bg-light" style="min-height: 70vh;">
  <div class="container py-5">
    <div class="text-center mb-5 pb-4" data-aos="zoom-in">
        <span class="text-uppercase fw-bold text-success mb-2 d-block tracking-wide">Property Catalog</span>
        <h2 class="display-5 fw-bold text-primary">Find Your Next Horizon</h2>
    </div>

    <div class="row g-5">
      <!-- Estate 1 -->
      <div class="col-lg-4 col-md-6" data-aos="fade-up" data-aos-delay="0">
        <div class="card border-0 shadow-sm estate-card h-100">
          <div class="estate-img-wrap">
            <span class="status-tag">Selling Fast</span>
            <img src="{{ asset('images/service1.jpeg') }}" alt="Imperial Gardens">
          </div>
          <div class="card-body p-4 p-md-5 bg-white d-flex flex-column">
            <h4 class="card-title fw-bold mb-3 text-dark">Imperial Gardens</h4>
            <p class="text-success mb-3 fw-bold"><i class="fas fa-map-marker-alt text-primary me-2"></i> Prime location, Bauchi Road</p>
            <p class="text-secondary lh-lg flex-grow-1">Experience incredible luxury and uncompromised security. Perfect for rapidly growing families and fast-paced executives demanding a pristine environment.</p>
            <a href="{{ route('contact') }}" class="btn btn-outline-primary btn-lg rounded-pill w-100 mt-4 fw-bold">Enquire Details</a>
          </div>
        </div>
      </div>

      <!-- Estate 2 -->
      <div class="col-lg-4 col-md-6" data-aos="fade-up" data-aos-delay="100">
        <div class="card border-0 shadow-sm estate-card h-100">
          <div class="estate-img-wrap">
            <span class="status-tag bg-success">Now Available</span>
            <img src="{{ asset('images/service2.jpeg') }}" alt="Sunset Villas">
          </div>
          <div class="card-body p-4 p-md-5 bg-white d-flex flex-column">
            <h4 class="card-title fw-bold mb-3 text-dark">Sunset Villas</h4>
            <p class="text-success mb-3 fw-bold"><i class="fas fa-shield-alt text-primary me-2"></i> Ultra-Secure Gated Community</p>
            <p class="text-secondary lh-lg flex-grow-1">A massive master-planned community featuring breathtaking modern amenities, robust 24/7 power, and exceptionally beautiful landscape designs.</p>
            <a href="{{ route('contact') }}" class="btn btn-outline-primary btn-lg rounded-pill w-100 mt-4 fw-bold">Enquire Details</a>
          </div>
        </div>
      </div>

      <!-- Estate 3 -->
      <div class="col-lg-4 col-md-6" data-aos="fade-up" data-aos-delay="200">
        <div class="card border-0 shadow-sm estate-card h-100">
          <div class="estate-img-wrap">
            <span class="status-tag bg-danger">Sold Out</span>
            <img src="{{ asset('images/service3.jpeg') }}" alt="Riverside Estate">
          </div>
          <div class="card-body p-4 p-md-5 bg-white d-flex flex-column">
            <h4 class="card-title fw-bold mb-3 text-dark">Riverside Estate</h4>
            <p class="text-danger mb-3 fw-bold"><i class="fas fa-tree text-primary me-2"></i> Scenic & Eco-friendly</p>
            <p class="text-secondary lh-lg flex-grow-1">Escape the city noise entirely. Riverside Estate offered deep tranquil living integrated seamlessly with fast transit routes.</p>
            <button class="btn btn-light btn-lg rounded-pill w-100 mt-4 fw-bold text-muted border" disabled>Closed</button>
          </div>
        </div>
      </div>
    </div>
  </div>
</section>

<!-- AOS Script -->
<script src="https://unpkg.com/aos@2.3.4/dist/aos.js"></script>
<script>
  document.addEventListener('DOMContentLoaded', function () {
    AOS.init({ duration: 800, once: true });
  });
</script>
@endsection
