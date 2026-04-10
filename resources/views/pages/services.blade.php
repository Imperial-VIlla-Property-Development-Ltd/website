@extends('layouts.app')

@section('title', 'Our Services — ImperialVilla')

@section('content')
<link href="https://unpkg.com/aos@2.3.4/dist/aos.css" rel="stylesheet">
<style>
  .accordion-button:not(.collapsed) {
    background-color: rgba(11, 44, 77, 0.05);
    color: var(--primary-color);
    box-shadow: none;
    font-weight: 700;
  }
  .accordion-button:focus {
    box-shadow: none;
    border-color: rgba(0,0,0,0.125);
  }
  .accordion-item {
    border: 1px solid rgba(0,0,0,0.05);
    border-radius: 10px !important;
    margin-bottom: 15px;
    overflow: hidden;
    box-shadow: 0 4px 6px rgba(0,0,0,0.02);
  }
</style>

<!-- HERO SECTION -->
<section class="page-hero text-center text-white py-6 position-relative" style="background: url('{{ asset('images/service2.jpeg') }}') center/cover no-repeat; padding: 120px 0;">
  <div class="position-absolute top-0 start-0 w-100 h-100" style="background: linear-gradient(rgba(11, 44, 77, 0.85), rgba(11, 44, 77, 0.7));"></div>
  <div class="container position-relative z-2">
    <h1 class="display-4 fw-bold animate__animated animate__fadeInDown">Our Premium Services</h1>
    <p class="lead animate__animated animate__fadeInUp animate__delay-1s mx-auto mt-3" style="max-width: 700px; font-weight:300;">
      Comprehensive, highly reliable solutions in Real Estate Development and Pension Facilitation.
    </p>
  </div>
</section>

<!-- MAIN SERVICES -->
<section class="py-6 bg-light">
  <div class="container py-5">
    <div class="text-center mb-5 pb-3" data-aos="zoom-in">
        <span class="text-uppercase fw-bold text-secondary mb-2 d-block tracking-wide">What We Can Do For You</span>
        <h2 class="display-5 fw-bold text-primary">Service Excellence</h2>
        <div class="mx-auto mt-4" style="width: 60px; height: 3px; background: var(--secondary-color);"></div>
    </div>

    <div class="row g-5">
      <!-- Service 1 -->
      <div class="col-md-4" data-aos="fade-up" data-aos-delay="0">
        <div class="card h-100 border-0 shadow-lg rounded-4 overflow-hidden position-relative group" style="transition: transform 0.4s;" onmouseover="this.style.transform='translateY(-15px)'" onmouseout="this.style.transform='translateY(0)'">
          <img src="{{ asset('images/service3.jpeg') }}" class="card-img-top" style="height: 250px; object-fit:cover; transition: transform 0.6s;">
          <div class="card-body p-5 bg-white position-relative">
            <h4 class="fw-bold text-primary mb-3">Property Development</h4>
            <p class="text-secondary lh-lg mb-0 text-md">We construct high-quality, modern residential and commercial structures tailored to stand the test of time, ensuring absolute security, comfort, and significant ROI.</p>
          </div>
        </div>
      </div>
      <!-- Service 2 -->
      <div class="col-md-4" data-aos="fade-up" data-aos-delay="100">
        <div class="card h-100 border-0 shadow-lg rounded-4 overflow-hidden position-relative" style="transition: transform 0.4s;" onmouseover="this.style.transform='translateY(-15px)'" onmouseout="this.style.transform='translateY(0)'">
          <img src="{{ asset('images/service1.jpeg') }}" class="card-img-top" style="height: 250px; object-fit:cover; transition: transform 0.6s;">
          <div class="card-body p-5 bg-white position-relative">
            <h4 class="fw-bold text-primary mb-3">25% Equity Mortgage</h4>
            <p class="text-secondary lh-lg mb-0 text-md">We actively facilitate the 25% RSA Equity Mortgage, allowing you to access a portion of your pension to seamlessly secure your dream home without stress.</p>
          </div>
        </div>
      </div>
      <!-- Service 3 -->
      <div class="col-md-4" data-aos="fade-up" data-aos-delay="200">
        <div class="card h-100 border-0 shadow-lg rounded-4 overflow-hidden position-relative" style="transition: transform 0.4s;" onmouseover="this.style.transform='translateY(-15px)'" onmouseout="this.style.transform='translateY(0)'">
          <img src="{{ asset('images/service2.jpeg') }}" class="card-img-top" style="height: 250px; object-fit:cover; transition: transform 0.6s;">
          <div class="card-body p-5 bg-white position-relative">
            <h4 class="fw-bold text-primary mb-3">Financial Consultancy</h4>
            <p class="text-secondary lh-lg mb-0 text-md">We offer high-tier expert financial consulting, empowering you with strategic advice on real estate portfolios and comprehensive wealth magnification strategies.</p>
          </div>
        </div>
      </div>
    </div>
  </div>
</section>

<!-- FAQ ACCORDION -->
<section class="py-6 bg-white border-top border-bottom">
  <div class="container py-5">
    <div class="row justify-content-center">
      <div class="col-lg-8" data-aos="fade-up">
        <div class="text-center mb-5">
          <span class="text-uppercase fw-bold text-success mb-2 d-block tracking-wide">Common Questions</span>
          <h2 class="display-6 fw-bold text-primary mb-3">Frequently Asked Questions</h2>
          <p class="text-secondary fs-5">Everything you need to know about our property investments and pension plans.</p>
        </div>

        <div class="accordion accordion-flush" id="faqAccordion">
          <!-- FAQ 1 -->
          <div class="accordion-item shadow-sm">
            <h2 class="accordion-header">
              <button class="accordion-button fw-bold py-4 fs-5" type="button" data-bs-toggle="collapse" data-bs-target="#faq1" aria-expanded="true" aria-controls="faq1">
                How do I start investing in an ImperialVilla property?
              </button>
            </h2>
            <div id="faq1" class="accordion-collapse collapse show" data-bs-parent="#faqAccordion">
              <div class="accordion-body text-secondary lh-lg fs-5">
                Starting is incredibly easy! Simply browse our available estates on our website, select the property that fits your life goals, and contact our expert team via the <a href="{{ route('contact') }}">Contact Page</a> or WhatsApp. We will guide you through the transparent documentation process.
              </div>
            </div>
          </div>
          <!-- FAQ 2 -->
          <div class="accordion-item shadow-sm">
            <h2 class="accordion-header">
              <button class="accordion-button collapsed fw-bold py-4 fs-5" type="button" data-bs-toggle="collapse" data-bs-target="#faq2" aria-expanded="false" aria-controls="faq2">
                What does your Pension Assistance cover?
              </button>
            </h2>
            <div id="faq2" class="accordion-collapse collapse" data-bs-parent="#faqAccordion">
              <div class="accordion-body text-secondary lh-lg fs-5">
                Our pension assistance covers document gathering, bureaucratic filing, consistent follow-ups with pension boards, and ultimate payout facilitation to assure you get what you are owed without extreme delay.
              </div>
            </div>
          </div>
          <!-- FAQ 3 -->
          <div class="accordion-item shadow-sm">
            <h2 class="accordion-header">
              <button class="accordion-button collapsed fw-bold py-4 fs-5" type="button" data-bs-toggle="collapse" data-bs-target="#faq3" aria-expanded="false" aria-controls="faq3">
                Are there hidden charges beyond the property cost?
              </button>
            </h2>
            <div id="faq3" class="accordion-collapse collapse" data-bs-parent="#faqAccordion">
              <div class="accordion-body text-secondary lh-lg fs-5">
                Absolutely not. Total transparency is our core principle. Every development fee, legal fee, and structural cost is outlined vividly before you sign any paperwork.
              </div>
            </div>
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
