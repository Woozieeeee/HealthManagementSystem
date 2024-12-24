@extends('layouts.app')

@section('title', 'Welcome to the HealthLink')

@section('content')

    <!-- Home Section -->
    <section class="hero-section d-flex align-items-center" id="home" style="width: 100%; margin:0;">
        <div class="container-fluid text-center p-5">
            <h1 class="display-4 text-white fw-bold mb-3">Welcome to the HealthLink</h1>
            <p class="lead text-white mb-4">Streamline patient referrals between Barangay and Regional Health Unit for faster, more efficient healthcare delivery.</p>
            <div class="d-flex justify-content-center gap-3">
                <a href="#features" class="btn btn-success btn-lg">Learn More</a>
                <a href="{{ route('login') }}" class="btn btn-success btn-lg">Get Started</a>
            </div>
        </div>
    </section>
    <!-- Home section ends -->

    <!-- Purpose section -->
    <section id="purpose" class="purpose-section py-5">
        <div class="container text-center" data-aos="fade-in" data-aos-delay="100">
            <h2 class="fw-bold mb-4">Our Purpose</h2>
            <p class="lead mb-5">The Health Referral System bridges the gap between Barangay Health Units and Regional Health Units, ensuring seamless patient referrals and faster healthcare services.</p>
            <div class="row g-4 mb-5">
                <div class="col-md-4">
                    <div class="card shadow-sm h-100" data-aos="zoom-in" data-aos-delay="200">
                        <div class="card-body text-center">
                            <i class="fas fa-bullseye fa-3x text-primary mb-3"></i>
                            <h5 class="fw-bold">Mission</h5>
                            <p>To provide streamlined and efficient referral process that connects patients to the care they need, when they need it.</p>
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="card shadow-sm h-100" data-aos="fade-in" data-aos-delay="300">
                        <div class="card-body text-center">
                            <i class="fas fa-eye fa-3x text-primary mb-3"></i>
                            <h5 class="fw-bold">Vision</h5>
                            <p>To be the leading digital platform that bridges healthcare facilities for inclusive and accessible medical services.</p>
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="card shadow-sm h-100" data-aos="fade-in" data-aos-delay="400">
                        <i class="fas fa-hand-holding-heart fa-3x text-primary mb-3" style="margin-top: 12px"></i>
                        <h5 class="fw-bold">Philosophy</h5>
                        <p>We believe in compassion, efficiency, and technology as pillars of quality healthcare delivery.</p>
                    </div>
                </div>
            </div>

            <div class="row g-4 mb-5">
                <div class="col-md-4">
                    <div class="card shadow-sm h-100" data-aos="zoom-in" data-aos-delay="200">
                        <div class="card-body text-center">
                            <i class="fas fa-hands-helping fa-3x text-primary mb-3"></i>
                            <h5 class="fw-bold">Collaboration</h5>
                            <p>Enhancing communication between healthcare providers for better patient outcomes.</p>
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="card shadow-sm h-100" data-aos="zoom-in" data-aos-delay="300">
                        <div class="card-body text-center">
                            <i class="fas fa-clock fa-3x text-primary mb-3"></i>
                            <h5 class="fw-bold">Efficiency</h5>
                            <p>Streamlining the referral process to save time and resources.</p>
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="card shadow-sm h-100" data-aos="zoom-in" data-aos-delay="400">
                        <div class="card-body text-center">
                            <i class="fas fa-users fa-3x text-primary mb-3"></i>
                            <h5 class="fw-bold">Accessibility</h5>
                            <p>Making healthcare services accessible to all, from communities to regional centers.</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- Purpose section ends -->

    <!-- Features section -->
    <section id="features" class="features-section py-5">
        <div class="container-fluid">
            <div class="text-center mb-5">
                <h2 class="fw-bold mb-4" data-aos="fade-up">Features</h2>
                <p class="lead mb-5" data-aos="fade-up" data-aos-delay="100">
                    Explore the key functionalities that make our Health Referrals System unique.
                </p>
            </div>

            <div id="featuresCarousel" class="carousel slide" data-bs-ride="carousel">
                <!-- Indicators -->
                <div class="carousel-indicators">
                    <button type="button" data-bs-target="#featuresCarousel" data-bs-slide-to="0" class="active" aria-current="true" aria-label="Slide 1"></button>
                    <button type="button" data-bs-target="#featuresCarousel" data-bs-slide-to="1" aria-label="Slide 2"></button>
                    <button type="button" data-bs-target="#featuresCarousel" data-bs-slide-to="2" aria-label="Slide 3"></button>
                    <button type="button" data-bs-target="#featuresCarousel" data-bs-slide-to="3" aria-label="Slide 4"></button>
                    <button type="button" data-bs-target="#featuresCarousel" data-bs-slide-to="4" aria-label="Slide 5"></button>
                </div>
                <div class="carousel-inner">
                    <!-- Slide 1 -->
                    <div class="carousel-item active">
                        <img src="{{ asset('images/pic5.jpg') }}" alt="Seamless Referrals" class="d-block w-100">
                        <div class="carousel-caption d-block">
                            <h3 class="fw-bold text-white">Seamless Referrals</h3>
                            <p class = "text-white">Effortlessly connect patients between Barangay and Regional Health Units for smooth and quick healthcare delivery.</p>
                        </div>
                    </div>

                    <!-- Slide 2 -->
                    <div class="carousel-item">
                        <img src="{{ asset('images/pic3.jpg') }}" alt="Real-Time Monitoring" class="d-block w-100">
                        <div class="carousel-caption d-block">
                            <h3 class="fw-bold text-white">Real-Time Monitoring</h3>
                            <p class = "text-white">Track referral statuses and healthcare statistics in real-time, ensuring transparency and efficiency.</p>
                        </div>
                    </div>

                    <!-- Slide 3 -->
                    <div class="carousel-item">
                        <img src="{{ asset('images/pic4.jpg') }}" alt="User-Friendly Interface" class="d-block w-100">
                        <div class="carousel-caption d-block">
                            <h3 class="fw-bold text-white">User-Friendly Interface</h3>
                            <p class = "text-white">Navigate and manage healthcare referrals effortlessly with a clean, intuitive design.</p>
                        </div>
                    </div>

                    <!-- Slide 4 -->
                    <div class="carousel-item">
                        <img src="{{ asset('images/pic7.jpg') }}" alt="Secure Data Management" class="d-block w-100">
                        <div class="carousel-caption d-block">
                            <h4 class="fw-bold text-white">Secure Data Management</h4>
                            <p class = "text-white">Ensure patient confidentiality with robust data security measures, keeping sensitive information safe.</p>
                        </div>
                    </div>

                    <!-- Slide 5 -->
                    <div class="carousel-item">
                        <img src="{{ asset('images/pic6.jpg') }}" alt="Automated Notification" class="d-block w-100">
                        <div class="carousel-caption d-block">
                            <h3 class="fw-bold text-white">Automated Notification</h3>
                            <p class = "text-white">Get instant updates on referral progress and other important alerts with automated notifications.</p>
                        </div>
                    </div>
                </div>

                <!-- Navigation Arrows -->
                <button class="carousel-control-prev" type="button" data-bs-target="#featuresCarousel" data-bs-slide="prev">
                    <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                    <span class="visually-hidden">Previous</span>
                </button>
                <button class="carousel-control-next" type="button" data-bs-target="#featuresCarousel" data-bs-slide="next">
                    <span class="carousel-control-next-icon" aria-hidden="true"></span>
                    <span class="visually-hidden">Next</span>
                </button>
            </div>
        </div>
    </section>
    <!-- Features section ends -->

    <!-- Benefits section -->
    <section id="benefits" class="benefits-section py-5">
        <div class="container text-center">
            <h2 class="fw-bold mb-4" data-aos="fade-up">Benefits</h2>
            <p class="lead mb-5" data-aos="fade-up" data-aos-delay="100">Discover how our Health Referral System improves healthcare delivery and efficiency.</p>

            <div class="row g-4">
                <div class="col-md-4" data-aos="fade-up" data-aos-delay="200">
                    <div class="card shadow-sm h-100">
                        <div class="card-body text-center">
                            <i class="fas fa-hands-helping fa-3x text-primary mb-3"></i>
                            <h5 class="fw-bold">Streamlined Referrals</h5>
                            <p>Save time and resources by automating patient referrals between health units.</p>
                        </div>
                    </div>
                </div>
                <div class="col-md-4" data-aos="fade-up" data-aos-delay="300">
                    <div class="card shadow-sm h-100">
                        <div class="card-body text-center">
                            <i class="fas fa-clock fa-3x text-primary mb-3"></i>
                            <h5 class="fw-bold">Time Saving</h5>
                            <p>Reduce waiting times and ensure faster healthcare service delivery.</p>
                        </div>
                    </div>
                </div>
                <div class="col-md-4" data-aos="fade-up" data-aos-delay="400">
                    <div class="card shadow-sm h-100">
                        <div class="card-body text-center">
                            <i class="fas fa-chart-line fa-3x text-primary mb-3"></i>
                            <h5 class="fw-bold">Improved Efficiency</h5>
                            <p>Optimize healthcare operations with real-time tracking and reporting tools.</p>
                        </div>
                    </div>
                </div>
                <div class="col-md-4" data-aos="fade-up" data-aos-delay="500">
                    <div class="card shadow-sm h-100">
                        <div class="card-body text-center">
                            <i class="fas fa-users fa-3x text-primary mb-3"></i>
                            <h5 class="fw-bold">Enhanced Accessibility</h5>
                            <p>Ensure healthcare services are accessible to communities of all sizes.</p>
                        </div>
                    </div>
                </div>
                <div class="col-md-4" data-aos="fade-up" data-aos-delay="600">
                    <div class="card shadow-sm h-100">
                        <div class="card-body text-center">
                            <i class="fas fa-shield-alt fa-3x text-primary mb-3"></i>
                            <h5 class="fw-bold">Secure and Reliable</h5>
                            <p>Protect patient data with robust security measures and reliable backups.</p>
                        </div>
                    </div>
                </div>
                <div class="col-md-4" data-aos="fade-up" data-aos-delay="700">
                    <div class="card shadow-sm h-100">
                        <div class="card-body text-center">
                            <i class="fas fa-hospital-alt fa-3x text-primary mb-3"></i>
                            <h5 class="fw-bold">Centralized Healthcare</h5>
                            <p>Manage Patient referrals and data from multiple health units in one platform.</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- Benefits section ends -->

    <!-- Contact section -->
    <section id="contact" class="contact-section py-5">
        <div class="container">
            <div class="text-center mb-5">
                <h2 class="fw-bold" data-aos="fade-up">Contact Us</h2>

                @if(session('success'))
                <div class="alert alert-success">{{ session('success')}}</div>
                @endif

                <p class="lead mb-5" data-aos="fade-up" data-aos-delay="100">Have questions or need assistance? Feel free to reach out to us anytime!</p>
            </div>
            <div class="row">
                <div class="col-md-5" data-aos="fade-right">
                    <h4 class="fw-bold mb-3">Our Contact Details</h4>
                    <p><i class="fas fa-envelope text-primary"></i>
                    Email: <a href="mailto:mechtitan@gmail.com" class="text-decoration-none">mechtitan@gmail.com</a></p>
                    <p><i class="fas fa-phone text-primary"></i> Phone: <a href="tel:+639924041688" class="text-decoration-none">+63 992 404 1688</a></p>
                    <p><i class="fas fa-map-marker-alt text-primary"></i> Address: Pamantasan ng Lungsod ng San Pablo</p>
                </div>
                <div class="col-md-7" data-aos="fade-left">
                    <h4 class="fw-bold mb-3">Send Us a Message</h4>
                    <form action="{{ route('contact.store') }}" method="POST" id="contact-form">
                        @csrf
                        <div class="mb-3">
                            <label for="name" class="form-label">Your Name</label>
                            <input type="text" class="form-control" id="name" name="name" placeholder="Enter your name" required>
                        </div>
                        <div class="mb-3">
                            <label for="email" class="form-label">Your Email</label>
                            <input type="email" class="form-control" id="email" name="email" placeholder="Enter your email" required>
                        </div>
                        <div class="mb-3">
                            <label for="message" class="form-label">Your Message</label>
                            <textarea name="message" class="form-control" id="message" rows="5" placeholder="Enter your message" required></textarea>
                        </div>
                        <button class="btn btn-primary">Send Message</button>
                    </form>
                </div>
            </div>
        </div>
    </section>
    <!-- Contact section ends -->

    {{-- custom modals --}}
    <div class="modal fade" id="successModal" tabindex="-1" aria-labelledby="successModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header bg-success text-white">
                    <h5 class="modal-title" id="successModalLabel">Message Sent</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    Your message has been successfully sent!
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-success" data-bs-dismiss="modal">OK</button>
                </div>
            </div>
        </div>
    </div>
    
@endsection