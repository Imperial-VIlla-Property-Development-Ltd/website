@extends('layouts.app')

@section('title', 'Contact Us — ImperialVilla')

@section('content')

<!-- HERO SECTION -->
<section class="page-hero text-center text-white py-6" style="background: linear-gradient(rgba(11, 44, 77, 0.8), rgba(11, 44, 77, 0.8)), url('{{ asset('images/service8.png') }}') center/cover no-repeat; padding: 100px 0;">
  <div class="container position-relative z-2">
    <h1 class="display-4 fw-bold animate__animated animate__fadeInDown text-white">Contact Us</h1>
    <p class="lead animate__animated animate__fadeInUp animate__delay-1s text-light mx-auto mt-3" style="max-width: 700px;">
      We’re here to help with your property enquiries, pension matters, or investments. Let’s talk!
    </p>
  </div>
</section>

<!-- CONTACT INFO SECTION -->
<section class="contact-info py-5 bg-white">
  <div class="container py-5">
    <div class="row text-center gy-4 justify-content-center">
      <div class="col-md-4">
        <div class="contact-card p-4 bg-light shadow-sm rounded-4 h-100" style="transition: all 0.3s;" onmouseover="this.style.transform='translateY(-10px)'; this.classList.add('shadow')" onmouseout="this.style.transform='translateY(0)'; this.classList.remove('shadow')">
          <i class="fas fa-map-marker-alt fa-3x text-primary mb-3"></i>
          <h4 class="fw-bold mb-3 text-dark">Our Locations</h4>
          <p class="text-primary fw-bold mb-1">Headquarters (Gombe)</p>
          <p class="text-secondary small mb-3">Doho Plaza, Adjacent Tumfure Police Station, Bauchi Road</p>
          <p class="text-primary fw-bold mb-1">Branch Offices</p>
          <p class="text-secondary small mb-0">Kaduna • Plateau • Adamawa</p>
        </div>
      </div>

      <div class="col-md-4">
        <div class="contact-card p-5 bg-light shadow-sm rounded-4 h-100" style="transition: all 0.3s;" onmouseover="this.style.transform='translateY(-10px)'; this.classList.add('shadow')" onmouseout="this.style.transform='translateY(0)'; this.classList.remove('shadow')">
          <i class="fas fa-phone-alt fa-3x text-success mb-4"></i>
          <h4 class="fw-bold mb-3 text-dark">Phone Number</h4>
          <p class="text-secondary fs-5">+234 802 352 7558</p>
        </div>
      </div>

      <div class="col-md-4">
        <div class="contact-card p-5 bg-light shadow-sm rounded-4 h-100" style="transition: all 0.3s;" onmouseover="this.style.transform='translateY(-10px)'; this.classList.add('shadow')" onmouseout="this.style.transform='translateY(0)'; this.classList.remove('shadow')">
          <i class="fas fa-envelope fa-3x text-danger mb-4"></i>
          <h4 class="fw-bold mb-3 text-dark">Email Address</h4>
          <p class="text-secondary fs-6 text-break">support@imperialvillapropertydevelopment.com</p>
        </div>
      </div>
    </div>
  </div>
</section>

<!-- CONTACT FORM -->
<section class="contact-form py-5 bg-light">
  <div class="container py-4">
    <div class="text-center mb-5" data-aos="zoom-in">
        <h2 class="display-6 fw-bold text-primary">Send Us a Quick Message</h2>
    </div>
    
    <div class="row justify-content-center">
      <div class="col-md-8">
        <form action="{{ route('contact.submit') }}" method="POST" class="p-5 bg-white shadow-lg rounded-4" data-aos="fade-up">
          @if(session('success'))
            <div class="alert alert-success fw-bold text-center mb-4">
              <i class="fas fa-check-circle me-2"></i> {{ session('success') }}
            </div>
          @endif
          @if(session('error'))
            <div class="alert alert-danger fw-bold text-center mb-4">
              <i class="fas fa-exclamation-triangle me-2"></i> {{ session('error') }}
            </div>
          @endif
          @csrf
          <div class="mb-4">
            <label for="name" class="form-label fw-bold text-dark">Full Name</label>
            <input type="text" id="name" name="name" class="form-control form-control-lg bg-light border-0" placeholder="e.g. John Doe" required>
          </div>

          <div class="mb-4">
            <label for="email" class="form-label fw-bold text-dark">Email Address</label>
            <input type="email" id="email" name="email" class="form-control form-control-lg bg-light border-0" placeholder="e.g. email@example.com" required>
          </div>

          <div class="mb-4">
            <label for="message" class="form-label fw-bold text-dark">Message</label>
            <textarea id="message" name="message" class="form-control form-control-lg bg-light border-0" rows="5" placeholder="Type your message..." required></textarea>
          </div>

          <div class="text-center mt-5">
            <button type="submit" class="btn btn-primary btn-lg px-5 rounded-pill shadow">
              <i class="fas fa-paper-plane me-2"></i> Send Message
            </button>
          </div>
        </form>
      </div>
    </div>
  </div>
</section>

<!-- SOCIAL MEDIA SECTION -->
<section class="social-media py-5 text-center bg-white" >
  <div class="container py-4" data-aos="fade-in">
    <h3 class="fw-bold mb-4 text-dark">Connect with Us</h3>
    <div class="d-flex justify-content-center gap-4 fs-2 mb-5">
      <a href="https://facebook.com/imperialvillaproperty" target="_blank" class="social-icon bg-facebook text-white shadow">
        <i class="fab fa-facebook-f"></i>
      </a>
      <a href="https://x.com/imperial_villa_" target="_blank" class="social-icon bg-twitter text-white shadow">
        <i class="fab fa-twitter"></i>
      </a>
      <a href="https://instagram.com/imperialvillaltd" target="_blank" class="social-icon bg-instagram text-white shadow">
        <i class="fab fa-instagram"></i>
      </a>
      <a href="mailto:support@imperialvillapropertydevelopment.com" class="social-icon bg-email text-white shadow">
        <i class="fas fa-envelope"></i>
      </a>
    </div>

    <a href="https://wa.me/2348023527558?text=Hello%20ImperialVilla!%20I%20want%20to%20make%20an%20enquiry."
       target="_blank"
       class="btn btn-success btn-lg shadow-lg pulse-btn rounded-pill px-5 py-3 fs-5 fw-bold">
      <i class="fab fa-whatsapp me-2 fs-4"></i> Chat on WhatsApp
    </a>
  </div>
</section>

<!-- MAP SECTION -->
<section class="map-section m-0 p-0" style="line-height:0;">
  <iframe
    src="https://www.google.com/maps?q=Doho%20Plaza%20Adjacent%20Tumfure%20Police%20Station%20Bauchi%20Road%20Gombe%20Nigeria&output=embed"
    width="100%"
    height="450"
    style="border:0;"
    allowfullscreen
    loading="lazy">
  </iframe>
</section>

<!-- Add this style inside the same blade file -->
<style>
  .social-icon {
    width: 65px;
    height: 65px;
    display: inline-flex;
    justify-content: center;
    align-items: center;
    border-radius: 50%;
    font-size: 1.8rem;
    transition: all 0.3s ease;
  }
  .social-icon:hover {
    transform: translateY(-8px) scale(1.1);
  }

  .bg-facebook { background-color: #1877f2; }
  .bg-instagram { background: radial-gradient(circle at 30% 107%, #fdf497 0%, #fdf497 5%, #fd5949 45%, #d6249f 60%, #285AEB 90%); }
  .bg-twitter { background-color: #1da1f2; }
  .bg-email { background-color: #d44638; }

  /* WhatsApp Button Pulse Animation */
  .pulse-btn {
    animation: pulse 2s infinite;
  }
  @keyframes pulse {
    0% { transform: scale(1); box-shadow: 0 0 0 0 rgba(37, 211, 102, 0.6); }
    70% { transform: scale(1.03); box-shadow: 0 0 0 15px rgba(37, 211, 102, 0); }
    100% { transform: scale(1); box-shadow: 0 0 0 0 rgba(37, 211, 102, 0); }
  }
</style>

<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css"/>
@endsection
