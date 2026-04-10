@extends('layouts.app')

@section('title', 'Thank You — ImperialVilla')

@section('content')
<!-- THANK YOU HERO -->
<section class="thankyou">
  <div class="container">
    <div class="thankyou-card">
      <i class="fas fa-check-circle"></i>
      <h1>Thank You!</h1>
      <p>Your enquiry has been received. Our support team will contact you shortly.</p>

      <div class="thankyou-buttons">
        <a href="{{ url('/') }}" class="btn-primary">Return Home</a>
        <a href="{{ route('services') }}" class="btn-secondary">View Our Services</a>
      </div>
    </div>
  </div>
</section>
@endsection
