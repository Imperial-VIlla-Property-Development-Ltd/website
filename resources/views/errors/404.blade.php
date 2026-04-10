@extends('layouts.app')

@section('title', 'Page Not Found — ImperialVilla')

@section('content')
<section class="py-6 d-flex align-items-center justify-content-center" style="min-height: 70vh; background: #f8fafc;">
    <div class="container text-center" data-aos="zoom-in">
        <div class="mb-4">
            <h1 class="display-1 fw-bold text-primary">404</h1>
            <div class="mx-auto" style="width: 100px; height: 5px; background: var(--secondary-color); border-radius: 5px;"></div>
        </div>
        <h2 class="fw-bold text-dark mb-4">Oops! This Page is Missing</h2>
        <p class="text-secondary fs-5 mb-5 mx-auto" style="max-width: 600px;">
            The property or page you are looking for might have been moved, deleted, or never existed in the first place.
        </p>
        <div class="d-flex flex-column flex-md-row justify-content-center gap-3">
            <a href="{{ url('/') }}" class="btn btn-primary btn-lg px-5 shadow">Back to Home</a>
            <a href="{{ route('contact') }}" class="btn btn-outline-primary btn-lg px-5">Report Issue</a>
        </div>
    </div>
</section>
@endsection
