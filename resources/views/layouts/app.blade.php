<!DOCTYPE html>
<html lang="en">
<head>
    <meta name="description" content="ImperialVilla Property Limited - Premium Property Development, 25% RSA Equity Mortgage Facilitation, and Financial Consultancy in Nigeria.">
    <meta name="keywords" content="Real Estate Nigeria, Property Development Gombe, 25% Equity Mortgage, Pensioner Support, ImperialVilla, House for sale Nigeria">
    <meta name="author" content="ImperialVilla">
    
    <!-- Open Graph / Facebook -->
    <meta property="og:type" content="website">
    <meta property="og:url" content="https://imperialvillapropertydevelopment.com/">
    <meta property="og:title" content="@yield('title', 'ImperialVilla — Premium Property Solutions')">
    <meta property="og:description" content="Building trust and transforming lives through premium property development and dedicated pension empowerment.">
    <meta property="og:image" content="{{ asset('images/logo.png') }}">

    <!-- Twitter -->
    <meta property="twitter:card" content="summary_large_image">
    <meta property="twitter:url" content="https://imperialvillapropertydevelopment.com/">
    <meta property="twitter:title" content="@yield('title', 'ImperialVilla — Premium Property Solutions')">
    <meta property="twitter:description" content="Building trust and transforming lives through premium property development and dedicated pension empowerment.">
    <meta property="twitter:image" content="{{ asset('images/logo.png') }}">

    <title>@yield('title', 'ImperialVilla — Premium Property Solutions')</title>

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- Google Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600&family=Outfit:wght@400;600;700;800&display=swap" rel="stylesheet">

    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">

    <!-- Custom CSS -->
    <link rel="icon" type="image/png" href="{{ asset('images/logo.png') }}">

    <style>
      :root {
        --primary-color: #0b2c4d;
        --secondary-color: #d4af37;
        --accent-color: #1b446f;
        --text-dark: #1f2937;
        --text-light: #f3f4f6;
      }

      /* Custom High-End Scrollbar & Selection */
      ::selection { background: var(--secondary-color); color: #fff; }
      ::-webkit-scrollbar { width: 10px; }
      ::-webkit-scrollbar-track { background: #f8fafc; }
      ::-webkit-scrollbar-thumb { background: #64748b; border-radius: 10px; border: 2px solid #f8fafc; }
      ::-webkit-scrollbar-thumb:hover { background: var(--primary-color); }

      body {
        font-family: 'Inter', sans-serif;
        background-color: #f8fafc;
        color: var(--text-dark);
        overflow-x: hidden;
      }

      h1, h2, h3, h4, h5, h6, .navbar-brand {
        font-family: 'Outfit', sans-serif;
      }

      /* Navbar styling */
      .navbar {
        background: rgba(255, 255, 255, 0.95);
        backdrop-filter: blur(15px);
        -webkit-backdrop-filter: blur(15px);
        border-bottom: 1px solid rgba(0, 0, 0, 0.05);
        transition: all 0.4s ease;
      }

      .navbar-brand {
        font-weight: 800;
        font-size: 1.6rem;
        color: var(--primary-color) !important;
        letter-spacing: -0.5px;
      }

      .navbar-brand span {
        color: var(--secondary-color);
      }

      .nav-link {
        color: #4b5563 !important;
        font-weight: 600;
        margin: 0 8px;
        position: relative;
        transition: color 0.3s ease;
        padding-bottom: 5px;
      }

      .nav-link:hover, .nav-link.active {
        color: var(--primary-color) !important;
      }

      .nav-link::after {
        content: '';
        position: absolute;
        width: 0;
        height: 2px;
        bottom: 0;
        left: 50%;
        background-color: var(--secondary-color);
        transition: all 0.3s cubic-bezier(0.68, -0.55, 0.265, 1.55);
        transform: translateX(-50%);
      }

      .nav-link:hover::after, .nav-link.active::after {
        width: 100%;
      }

      /* Premium Pulse Buttons */
      .btn-primary {
        background: linear-gradient(135deg, var(--primary-color), var(--accent-color));
        border: none;
        border-radius: 30px;
        font-weight: 600;
        padding: 12px 28px;
        box-shadow: 0 4px 15px rgba(11, 44, 77, 0.25);
        transition: all 0.3s cubic-bezier(0.175, 0.885, 0.32, 1.275);
        color: #fff;
        position: relative;
        overflow: hidden;
      }

      .btn-primary::after {
        content: ''; position: absolute; top: -50%; left: -50%; width: 200%; height: 200%; background: rgba(255,255,255,0.1); transform: rotate(30deg) translate(-100%, -100%); transition: all 0.5s ease;
      }

      .btn-primary:hover::after {
        transform: rotate(30deg) translate(100%, 100%);
      }

      .btn-primary:hover {
        transform: translateY(-4px) scale(1.02);
        box-shadow: 0 10px 25px rgba(11, 44, 77, 0.4);
        background: linear-gradient(135deg, var(--accent-color), var(--primary-color));
        color: #fff;
      }

      /* Premium Footer */
      footer {
        background: #0b1a2e;
        position: relative;
        color: var(--text-light);
        padding: 80px 0 40px;
        overflow: hidden;
      }
      
      footer::before {
        content: '';
        position: absolute;
        top: 0; left: 0; width: 100%; height: 5px;
        background: linear-gradient(90deg, var(--secondary-color), var(--primary-color));
      }

      footer h3, footer h4 {
        color: #fff;
        font-weight: 700;
        margin-bottom: 24px;
      }

      footer p {
        color: #94a3b8;
        line-height: 1.8;
      }

      footer ul {
        list-style: none;
        padding: 0;
      }

      footer ul li {
        margin-bottom: 14px;
      }

      footer ul li a {
        color: #94a3b8;
        text-decoration: none;
        transition: all 0.3s ease;
        display: inline-block;
      }

      footer ul li a:hover {
        color: var(--secondary-color);
        transform: translateX(8px);
      }

      .footer-bottom {
        border-top: 1px solid rgba(255, 255, 255, 0.08);
        margin-top: 50px;
        padding-top: 25px;
        text-align: center;
        color: #64748b;
        font-size: 0.95rem;
      }

      /* Floating WhatsApp Button */
      .whatsapp-float {
        position: fixed;
        width: 65px;
        height: 65px;
        bottom: 35px;
        right: 35px;
        background: linear-gradient(135deg, #25D366, #128C7E);
        color: #fff;
        border-radius: 50%;
        text-align: center;
        font-size: 32px;
        box-shadow: 0 8px 25px rgba(37, 211, 102, 0.5);
        z-index: 1000;
        display: flex;
        align-items: center;
        justify-content: center;
        transition: all 0.4s cubic-bezier(0.175, 0.885, 0.32, 1.275);
      }

      .whatsapp-float:hover {
        transform: scale(1.15) translateY(-5px);
        color: white;
        box-shadow: 0 12px 30px rgba(37, 211, 102, 0.6);
      }

      .whatsapp-float i {
        margin-top: 2px;
      }
      
      .hover-float {
        transition: all 0.4s cubic-bezier(0.175, 0.885, 0.32, 1.275);
        display: inline-block;
      }
      .hover-float:hover {
        transform: translateY(-8px) scale(1.1);
        color: var(--secondary-color) !important;
      }
    </style>
</head>
<body>

<!-- ===== NAVBAR ===== -->
<header class="sticky-top">
  <nav class="navbar navbar-expand-lg py-3" id="mainNavbar">
    <div class="container">
      <a class="navbar-brand d-flex align-items-center gap-2" href="{{ url('/') }}">
        <img src="{{ asset('images/logo.png') }}" alt="ImperialVilla" style="height: 40px; width: auto; object-fit: contain;">
        <div>Imperial<span>Villa</span></div>
      </a>

      <button class="navbar-toggler border-0 shadow-none" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
        <i class="fas fa-bars-staggered text-dark fs-2"></i>
      </button>

      <div class="collapse navbar-collapse justify-content-end" id="navbarNav">
        <ul class="navbar-nav align-items-center gap-3">
          <li class="nav-item">
            <a class="nav-link {{ request()->is('/') ? 'active' : '' }}" href="{{ url('/') }}">Home</a>
          </li>
          <li class="nav-item">
            <a class="nav-link {{ request()->is('about') ? 'active' : '' }}" href="{{ route('about') }}">About</a>
          </li>
          <li class="nav-item">
            <a class="nav-link {{ request()->is('services') ? 'active' : '' }}" href="{{ route('services') }}">Services</a>
          </li>
          <li class="nav-item">
            <a class="nav-link {{ request()->is('estates') ? 'active' : '' }}" href="{{ route('estates') }}">Estates</a>
          </li>
          <li class="nav-item ms-lg-3">
            <a class="btn btn-primary shadow" href="{{ route('contact') }}">Get in Touch</a>
          </li>
        </ul>
      </div>
    </div>
  </nav>
</header>

<!-- ===== MAIN CONTENT ===== -->
<main>
  @yield('content')
</main>

<!-- ===== FOOTER ===== -->
<footer>
  <div class="container">
    <div class="row text-start gy-5">
      <div class="col-lg-4 col-md-6 pe-md-5">
        <h3>ImperialVilla</h3>
        <p>Building trust and transforming lives through premium property development and dedicated pension empowerment. We specialize in making your dream home a secure reality.</p>
        
        <div class="d-flex gap-4 mt-4">
          <a href="https://facebook.com/imperialvillaproperty" target="_blank" class="text-white fs-4 hover-float"><i class="fab fa-facebook-f"></i></a>
          <a href="https://x.com/imperial_villa_" target="_blank" class="text-white fs-4 hover-float"><i class="fab fa-x-twitter"></i></a>
          <a href="https://instagram.com/imperialvillaltd" target="_blank" class="text-white fs-4 hover-float"><i class="fab fa-instagram"></i></a>
        </div>
      </div>

      <div class="col-lg-2 col-md-6">
        <h4>Quick Links</h4>
        <ul>
          <li><a href="{{ url('/') }}"><i class="fas fa-arrow-right fs-6 me-2 small text-secondary"></i>Home</a></li>
          <li><a href="{{ route('about') }}"><i class="fas fa-arrow-right fs-6 me-2 small text-secondary"></i>About</a></li>
          <li><a href="{{ route('services') }}"><i class="fas fa-arrow-right fs-6 me-2 small text-secondary"></i>Services</a></li>
          <li><a href="{{ route('estates') }}"><i class="fas fa-arrow-right fs-6 me-2 small text-secondary"></i>Estates</a></li>
        </ul>
      </div>

      <div class="col-lg-3 col-md-6">
        <h4>Legal</h4>
        <ul>
          <li><a href="#"><i class="fas fa-arrow-right fs-6 me-2 small text-secondary"></i>Privacy Policy</a></li>
          <li><a href="{{ route('terms') }}"><i class="fas fa-arrow-right fs-6 me-2 small text-secondary"></i>Terms of Service</a></li>
          <li><a href="{{ route('contact') }}"><i class="fas fa-arrow-right fs-6 me-2 small text-secondary"></i>Support Center</a></li>
        </ul>
      </div>

      <div class="col-lg-3 col-md-6">
        <h4>Our Locations</h4>
        <div class="d-flex align-items-start mb-3">
          <i class="fas fa-building text-secondary mt-1 me-3 fs-5"></i>
          <div>
            <p class="mb-1 text-white fw-bold">Headquarters (Gombe)</p>
            <p class="mb-0 text-secondary small">Doho Plaza, Adjacent Tumfure Police Station, Bauchi Road</p>
          </div>
        </div>
        <div class="d-flex align-items-start mb-4">
          <i class="fas fa-code-branch text-secondary mt-1 me-3 fs-5"></i>
          <div>
            <p class="mb-1 text-white fw-bold">Branch Offices</p>
            <p class="mb-0 text-secondary small">Kaduna • Plateau • Adamawa</p>
          </div>
        </div>
        <div class="d-flex align-items-center mb-3">
          <i class="fas fa-phone-alt text-secondary me-3 fs-5"></i>
          <p class="mb-0 text-secondary">+234 802 352 7558</p>
        </div>
        <div class="d-flex align-items-center">
          <i class="fas fa-envelope text-secondary me-3 fs-5"></i>
          <p class="mb-0 text-secondary small" style="word-break: break-all;">support@imperialvillapropertydevelopment.com</p>
        </div>
      </div>
    </div>

    <div class="footer-bottom">
      <p>© <span id="currentYear"></span> ImperialVilla Property Limited. All Rights Reserved. Crafted with precision.</p>
    </div>
  </div>
</footer>

<!-- ===== Floating WhatsApp Chat Button ===== -->
<a href="https://wa.me/2348023527558?text=Hello%20ImperialVilla!%20I%20would%20like%20to%20make%20an%20enquiry."
   class="whatsapp-float"
   target="_blank"
   title="Chat with us on WhatsApp">
  <i class="fab fa-whatsapp"></i>
</a>

<!-- Bootstrap JS Bundle -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

<!-- Custom Global Scripts -->
<script>
  // Dynamic Year
  document.getElementById('currentYear').textContent = new Date().getFullYear();

  // Shrinking Sticky Navbar Logic
  document.addEventListener('scroll', function() {
    const navbar = document.getElementById('mainNavbar');
    if (window.scrollY > 50) {
      navbar.classList.add('py-2', 'shadow-sm');
      navbar.classList.remove('py-3');
    } else {
      navbar.classList.add('py-3');
      navbar.classList.remove('py-2', 'shadow-sm');
    }
  });
</script>

</body>
</html>
