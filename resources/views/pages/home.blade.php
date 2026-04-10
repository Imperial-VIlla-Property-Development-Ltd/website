@extends('layouts.app')

@section('title', 'ImperialVilla — Premium Property Solutions')

@section('content')
    <link href="https://unpkg.com/aos@2.3.4/dist/aos.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css" />

    <style>
        /* Hero Carousel Styles */
        .hero-carousel {
            height: 100vh;
            min-height: 600px;
            position: relative;
        }

        .carousel-item {
            height: 100vh;
            min-height: 600px;
            background-size: cover;
            background-position: center;
            image-rendering: -webkit-optimize-contrast;
        }

        .hero-overlay {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: rgba(0, 0, 0, 0.25);
        }

        .hero-content {
            position: absolute;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            width: 100%;
            z-index: 10;
            text-align: center;
            text-shadow: 2px 2px 4px rgba(0, 0, 0, 0.8);
        }

        .carousel-caption-custom {
            max-width: 800px;
            margin: 0 auto;
            background: rgba(11, 44, 77, 0.65);
            backdrop-filter: blur(10px);
            padding: 50px 40px;
            border-radius: 20px;
            border: 1px solid rgba(255, 255, 255, 0.1);
        }

        /* Stats Counter Section */
        .stat-box {
            transition: transform 0.4s ease;
            padding: 30px;
            border-radius: 15px;
            background: #fff;
            border-bottom: 4px solid var(--secondary-color);
        }

        .stat-box:hover {
            transform: translateY(-10px);
            box-shadow: 0 15px 30px rgba(0, 0, 0, 0.08);
        }

        .stat-number {
            font-size: 3.5rem;
            font-weight: 800;
            color: var(--primary-color);
            font-family: 'Outfit', sans-serif;
        }

        /* Service Cards */
        .service-card {
            transition: all 0.4s cubic-bezier(0.175, 0.885, 0.32, 1.275);
            border-radius: 15px;
            overflow: hidden;
            background: white;
            border: 1px solid rgba(0, 0, 0, 0.05);
        }

        .service-card:hover {
            transform: translateY(-15px);
            box-shadow: 0 20px 40px rgba(0, 0, 0, 0.1) !important;
            border-color: transparent;
        }

        .service-icon-wrap {
            width: 80px;
            height: 80px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 auto 25px;
            background: linear-gradient(135deg, rgba(11, 44, 77, 0.1), rgba(212, 175, 55, 0.15));
            transition: all 0.5s ease;
        }

        .service-card:hover .service-icon-wrap {
            background: linear-gradient(135deg, var(--primary-color), var(--secondary-color));
            color: white !important;
            transform: rotateY(180deg);
        }

        .service-card:hover .service-icon-wrap i {
            color: white !important;
        }

        /* Portfolio Cards */
        .portfolio-card {
            border-radius: 15px;
            overflow: hidden;
            transition: all 0.4s ease;
            border: none;
        }

        .portfolio-img-wrap {
            overflow: hidden;
            position: relative;
            height: 260px;
        }

        .portfolio-card img {
            transition: all 0.6s ease;
            object-fit: cover;
            height: 100%;
            width: 100%;
        }

        .portfolio-card:hover img {
            transform: scale(1.1);
        }

        .status-tag {
            position: absolute;
            top: 15px;
            right: 15px;
            background: var(--secondary-color);
            color: #fff;
            padding: 5px 15px;
            border-radius: 20px;
            font-weight: 600;
            font-size: 0.85rem;
            z-index: 2;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.2);
        }

        /* Testimonials */
        .testimonial-card {
            background: #f8fafc;
            border-radius: 20px;
            padding: 40px;
            position: relative;
            border-left: 5px solid var(--primary-color);
        }

        .testimonial-card::before {
            content: '\f10d';
            font-family: 'Font Awesome 6 Free';
            font-weight: 900;
            position: absolute;
            top: 20px;
            right: 30px;
            font-size: 3rem;
            color: rgba(11, 44, 77, 0.05);
        }

        /* Parallax CTA */
        .parallax-cta {
            position: relative;
            background-image: url('{{ asset('images/service8.png') }}');
            background-attachment: fixed;
            background-position: center;
            background-size: cover;
            padding: 100px 0;
        }

        .parallax-overlay {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: linear-gradient(135deg, rgba(11, 44, 77, 0.9), rgba(27, 68, 111, 0.85));
        }
    </style>

    <!-- HERO CAROUSEL -->
    <div id="heroCarousel" class="carousel slide carousel-fade hero-carousel" data-bs-ride="carousel" data-bs-pause="false">
        <div class="carousel-indicators">
            <button type="button" data-bs-target="#heroCarousel" data-bs-slide-to="0" class="active" aria-current="true"
                aria-label="Slide 1"></button>
            <button type="button" data-bs-target="#heroCarousel" data-bs-slide-to="1" aria-label="Slide 2"></button>
            <button type="button" data-bs-target="#heroCarousel" data-bs-slide-to="2" aria-label="Slide 3"></button>
        </div>
        <div class="carousel-inner">
            <div class="carousel-item active" style="background-image: url('{{ asset('images/image1.jpg') }}');">
                <div class="hero-overlay"></div>
            </div>
            <div class="carousel-item" style="background-image: url('{{ asset('images/image2.jpg') }}');">
                <div class="hero-overlay"></div>
            </div>
            <div class="carousel-item" style="background-image: url('{{ asset('images/image3.jpg') }}');">
                <div class="hero-overlay"></div>
            </div>
        </div>

        <div class="hero-content text-white container px-3">
            <div class="carousel-caption-custom shadow-lg glass-effect animate__animated animate__fadeIn">
                <!-- Company Logo in Hero -->
                <div class="mb-4 d-flex justify-content-center">
                    <img src="{{ asset('images/log.png') }}" alt="ImperialVilla Logo"
                        class="animate__animated animate__pulse animate__infinite"
                        style="max-height: 80px; width: auto; filter: drop-shadow(0 0 10px rgba(255,255,255,0.3));">
                </div>

                <h1 class="display-3 fw-bold mb-3 animate__animated animate__fadeInDown" style="letter-spacing:-1.5px;">
                    Building <span style="color: var(--secondary-color);">Secure</span> Futures</h1>

                <p class="lead mb-5 animate__animated animate__fadeInUp animate__delay-1s text-light fs-4 mx-auto"
                    style="font-weight:300; max-width: 650px; line-height: 1.6;">
                    Providing high-quality properties and specialized <span class="fw-bold">25% Equity Mortgage</span>
                    solutions with transparency and absolute client focus.
                </p>

                <div
                    class="d-flex flex-column flex-md-row justify-content-center gap-4 animate__animated animate__zoomIn animate__delay-2s">
                    <a href="{{ route('estates') }}" class="btn btn-lg btn-primary shadow-lg px-5 py-3">Explore Estates</a>
                    <a href="{{ route('contact') }}" class="btn btn-lg btn-outline-light rounded-pill px-5 py-3"
                        style="border-width: 2px; transition: all 0.3s ease;">
                        Consult With Us
                    </a>
                </div>
            </div>
        </div>
    </div>

    <!-- STAT COUNTERS -->
    <section class="py-5" style="background-color: #f1f5f9; margin-top: -30px; position:relative; z-index:20;">
        <div class="container pb-4">
            <div class="row g-4 justify-content-center text-center">
                <div class="col-md-4 col-sm-6" data-aos="fade-up" data-aos-delay="0">
                    <div class="stat-box shadow-sm">
                        <div class="stat-number counter" data-target="150">0</div>
                        <p class="text-secondary fw-bold text-uppercase tracking-wide mb-0">Properties Sold</p>
                    </div>
                </div>
                <div class="col-md-4 col-sm-6" data-aos="fade-up" data-aos-delay="100">
                    <div class="stat-box shadow-sm">
                        <div class="stat-number counter" data-target="850">0</div>
                        <p class="text-secondary fw-bold text-uppercase tracking-wide mb-0">Pensioners Assisted</p>
                    </div>
                </div>
                <div class="col-md-4 col-sm-6" data-aos="fade-up" data-aos-delay="200">
                    <div class="stat-box shadow-sm">
                        <div class="stat-number counter" data-target="15">0</div>
                        <p class="text-secondary fw-bold text-uppercase tracking-wide mb-0">Years of Excellence</p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- HIGHLIGHT / WHY CHOOSE US -->
    <section class="py-6 py-md-5 bg-white">
        <div class="container my-5">
            <div class="row g-5 align-items-center">
                <div class="col-lg-6" data-aos="fade-right">
                    <span class="text-uppercase fw-bold text-success mb-2 d-block tracking-wide">Why Choose Us</span>
                    <h2 class="display-5 fw-bold text-primary mb-4">A legacy built on absolute trust and results.</h2>
                    <p class="text-secondary lh-lg fs-5 mb-4">At Imperial Villa Property Limited, we believe that owning a
                        quality home should be within reach. Our mission goes beyond building structures; we build security,
                        stability, and futures.</p>
                    <div class="d-flex align-items-start mb-4">
                        <div class="bg-primary text-white rounded-circle p-3 me-3"><i class="fas fa-gem fs-4"></i></div>
                        <div>
                            <h4 class="fw-bold mb-1">Premium Quality</h4>
                            <p class="text-secondary mb-0">Uncompromising standards in every brick we lay.</p>
                        </div>
                    </div>
                    <div class="d-flex align-items-start">
                        <div class="bg-secondary text-white rounded-circle p-3 me-3"><i class="fas fa-handshake fs-4"></i>
                        </div>
                        <div>
                            <h4 class="fw-bold mb-1">Transparent Processes</h4>
                            <p class="text-secondary mb-0">Clear, legally sound documentation without hidden fees.</p>
                        </div>
                    </div>
                </div>
                <div class="col-lg-6 position-relative" data-aos="fade-left">
                    <div class="position-absolute bg-primary rounded-circle"
                        style="width: 300px; height: 300px; top: -20px; right: -20px; opacity: 0.05; z-index: 0;"></div>
                    <img src="{{ asset('images/service2.jpeg') }}" class="img-fluid rounded-4 shadow-lg position-relative"
                        style="z-index: 1;" alt="Why Choose Us">
                </div>
            </div>
        </div>
    </section>

    <!-- MISSION & VISION -->
    <section class="py-6 bg-light border-top border-bottom">
        <div class="container my-4">
            <div class="row g-5 align-items-stretch">
                <div class="col-md-6" data-aos="fade-right">
                    <div class="card border-0 shadow-sm h-100 p-5 service-card" style="background: white;">
                        <div class="card-body p-0">
                            <div class="d-flex align-items-center mb-4">
                                <div class="bg-primary text-white rounded p-3 me-3 shadow-sm">
                                    <i class="fas fa-bullseye fa-2x"></i>
                                </div>
                                <h3 class="h3 text-primary mb-0 fw-bold">Our Mission</h3>
                            </div>
                            <p class="text-secondary lh-lg mb-0 mt-3 fs-5">At Imperial Villa Property Limited, we believe
                                that owning a quality home should be within reach for every individual and family. Our
                                mission is to deliver value-driven property solutions that make this vision a
                                reality—combining strategic financing models with expert guidance tailored to your unique
                                needs.</p>
                        </div>
                    </div>
                </div>

                <div class="col-md-6" data-aos="fade-left">
                    <div class="card border-0 shadow-sm h-100 p-5 service-card" style="background: white;">
                        <div class="card-body p-0">
                            <div class="d-flex align-items-center mb-4">
                                <div class="bg-success text-white rounded p-3 me-3 shadow-sm">
                                    <i class="fas fa-eye fa-2x"></i>
                                </div>
                                <h3 class="h3 text-success mb-0 fw-bold">Our Vision</h3>
                            </div>
                            <p class="text-secondary lh-lg mb-0 mt-3 fs-5">To be the trusted leader in property and pension
                                facilitation across Nigeria. We strive to create thriving communities through sustainable
                                housing while enabling dignified retirements for our hardworking pensioners.</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- SERVICES GRID -->
    <section class="py-6 bg-light">
        <div class="container py-5">
            <div class="text-center mb-5 pb-3" data-aos="fade-up">
                <span class="text-uppercase text-secondary fw-bold tracking-wide small">Our Expertise</span>
                <h2 class="display-4 fw-bold mt-2 text-primary">Core Services</h2>
                <div class="mx-auto mt-4 mb-4"
                    style="width: 80px; height: 4px; background: linear-gradient(90deg, var(--secondary-color), var(--primary-color)); border-radius: 2px;">
                </div>
            </div>

            <div class="row g-4">
                <!-- Feature 1 -->
                <div class="col-md-4" data-aos="fade-up" data-aos-delay="0">
                    <div class="card h-100 service-card text-center p-5 shadow-sm">
                        <div class="service-icon-wrap">
                            <i class="fas fa-home fs-1 text-primary"></i>
                        </div>
                        <h4 class="card-title fw-bold text-dark">Property Development</h4>
                        <p class="card-text text-secondary mt-3 lh-lg">Building modern, durable homes and estates tailored
                            to high value appreciation for you and your family.</p>
                    </div>
                </div>
                <!-- Feature 2 -->
                <div class="col-md-4" data-aos="fade-up" data-aos-delay="100">
                    <div class="card h-100 service-card text-center p-5 shadow-sm">
                        <div class="service-icon-wrap">
                            <i class="fas fa-file-signature fs-1 text-primary"></i>
                        </div>
                        <h4 class="card-title fw-bold text-dark">25% Equity Mortgage</h4>
                        <p class="card-text text-secondary mt-3 lh-lg">We facilitate the 25% RSA Equity Mortgage, allowing
                            you to access a portion of your pension to seamlessly secure your dream home.</p>
                    </div>
                </div>
                <!-- Feature 3 -->
                <div class="col-md-4" data-aos="fade-up" data-aos-delay="200">
                    <div class="card h-100 service-card text-center p-5 shadow-sm">
                        <div class="service-icon-wrap">
                            <i class="fas fa-chart-line fs-1 text-primary"></i>
                        </div>
                        <h4 class="card-title fw-bold text-dark">Financial Consultancy</h4>
                        <p class="card-text text-secondary mt-3 lh-lg">Expert financial consulting providing strategic
                            advice on real estate investments and robust wealth management.</p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- PORTFOLIO / ESTATES PREVIEW -->
    <section class="py-6 bg-white">
        <div class="container py-5">
            <div class="d-flex flex-column flex-md-row justify-content-between align-items-md-end mb-5 pb-2"
                data-aos="fade-in">
                <div>
                    <span class="text-uppercase fw-bold text-success small">Portfolio</span>
                    <h2 class="display-5 fw-bold mt-2 mb-0 text-primary">Featured Estates</h2>
                </div>
                <a href="{{ route('estates') }}"
                    class="btn btn-outline-primary rounded-pill px-4 py-2 mt-3 mt-md-0 shadow-sm fw-bold">View full
                    portfolio <i class="fas fa-arrow-right ms-2"></i></a>
            </div>

            <div class="row g-4">
                <div class="col-md-4" data-aos="zoom-in" data-aos-delay="0">
                    <div class="card portfolio-card shadow-sm">
                        <div class="portfolio-img-wrap">
                            <span class="status-tag">Selling Fast</span>
                            <img src="{{ asset('images/service1.jpeg') }}" alt="Imperial Gardens">
                        </div>
                        <div class="card-body p-4 bg-light">
                            <h4 class="card-title fw-bold mb-2">Imperial Gardens</h4>
                            <p class="text-secondary mb-0"><i class="fas fa-map-marker-alt text-primary me-2"></i> Prime
                                location, Gombe.</p>
                        </div>
                    </div>
                </div>

                <div class="col-md-4" data-aos="zoom-in" data-aos-delay="100">
                    <div class="card portfolio-card shadow-sm">
                        <div class="portfolio-img-wrap">
                            <span class="status-tag bg-success">Available</span>
                            <img src="{{ asset('images/service2.jpeg') }}" alt="Sunset Villas">
                        </div>
                        <div class="card-body p-4 bg-light">
                            <h4 class="card-title fw-bold mb-2">Sunset Villas</h4>
                            <p class="text-secondary mb-0"><i class="fas fa-shield-alt text-primary me-2"></i> Secure
                                gated community.</p>
                        </div>
                    </div>
                </div>

                <div class="col-md-4" data-aos="zoom-in" data-aos-delay="200">
                    <div class="card portfolio-card shadow-sm">
                        <div class="portfolio-img-wrap">
                            <span class="status-tag bg-danger">Sold Out</span>
                            <img src="{{ asset('images/service3.jpeg') }}" alt="Riverside Estate">
                        </div>
                        <div class="card-body p-4 bg-light">
                            <h4 class="card-title fw-bold mb-2">Riverside Estate</h4>
                            <p class="text-secondary mb-0"><i class="fas fa-tree text-primary me-2"></i> Scenic
                                eco-friendly views.</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- TESTIMONIALS -->
    <section class="py-6 bg-light border-top">
        <div class="container py-5">
            <div class="row justify-content-center text-center mb-5" data-aos="fade-up">
                <div class="col-lg-6">
                    <span class="text-uppercase fw-bold text-secondary tracking-wide small">Testimonials</span>
                    <h2 class="display-5 fw-bold text-primary mt-2">What Our Clients Say</h2>
                </div>
            </div>

            <div id="testimonialCarousel" class="carousel slide" data-bs-ride="carousel" data-aos="zoom-in">
                <div class="carousel-inner pb-5">
                    <div class="carousel-item active">
                        <div class="row justify-content-center">
                            <div class="col-md-8">
                                <div class="testimonial-card shadow-sm text-center">
                                    <i class="fas fa-user-circle fa-4x text-muted mb-3"></i>
                                    <h5 class="fw-bold mb-1">Ahmed Ibrahim</h5>
                                    <p class="text-success small fw-bold mb-4">Property Investor</p>
                                    <p class="fs-5 text-secondary fst-italic">"ImperialVilla delivered precisely what they
                                        promised. The documentation was fully transparent, and the value of my property at
                                        Imperial Gardens has already appreciated significantly."</p>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="carousel-item">
                        <div class="row justify-content-center">
                            <div class="col-md-8">
                                <div class="testimonial-card shadow-sm text-center">
                                    <i class="fas fa-user-circle fa-4x text-muted mb-3"></i>
                                    <h5 class="fw-bold mb-1">Fatima Musa</h5>
                                    <p class="text-success small fw-bold mb-4">Retired Teacher</p>
                                    <p class="fs-5 text-secondary fst-italic">"I struggled for months to access my pension.
                                        The team at ImperialVilla handled my documents professionally and got my equipment
                                        delivered without any stress. Highly recommended!"</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="carousel-indicators mb-0">
                    <button type="button" data-bs-target="#testimonialCarousel" data-bs-slide-to="0"
                        class="active bg-primary"></button>
                    <button type="button" data-bs-target="#testimonialCarousel" data-bs-slide-to="1"
                        class="bg-primary"></button>
                </div>
            </div>
        </div>
    </section>

    <!-- PARALLAX CTA -->
    <section class="parallax-cta text-white text-center">
        <div class="parallax-overlay"></div>
        <div class="container position-relative py-5" style="z-index: 2;" data-aos="fade-up">
            <h2 class="display-4 fw-bold mb-4">Ready to start your journey?</h2>
            <p class="lead mb-5 text-light mx-auto fs-4" style="max-width: 800px; font-weight:300;">Step into the future
                with a team dedicated entirely to your property success and pension comfort.</p>
            <a href="{{ route('contact') }}"
                class="btn btn-light btn-lg text-primary px-5 py-3 rounded-pill fw-bold shadow-lg fs-5">Contact an Expert
                Today <i class="fas fa-arrow-right ms-2"></i></a>
        </div>
    </section>

    <!-- AOS JS & Counter Logic -->
    <script src="https://unpkg.com/aos@2.3.4/dist/aos.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            AOS.init({
                duration: 1000,
                once: true,
                offset: 100
            });

            // Animated Counter Logic
            const counters = document.querySelectorAll('.counter');
            const speed = 200;

            const animateCounters = () => {
                counters.forEach(counter => {
                    const updateCount = () => {
                        const target = +counter.getAttribute('data-target');
                        const count = +counter.innerText;
                        const inc = target / speed;
                        if (count < target) {
                            counter.innerText = Math.ceil(count + inc);
                            setTimeout(updateCount, 10);
                        } else {
                            counter.innerText = target + "+";
                        }
                    };
                    updateCount();
                });
            };

            // Trigger counters when scrolled into view
            let triggered = false;
            window.addEventListener('scroll', () => {
                if (!triggered && window.scrollY > 150) {
                    animateCounters();
                    triggered = true;
                }
            });
        });
    </script>
@endsection
