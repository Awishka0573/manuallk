<?php
session_start();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Font Awesome -->
    <link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <!-- SweetAlert2 -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11.7.32/dist/sweetalert2.min.css">
    <link rel="icon" type="image/png" href="../assets/images/logotransp.png">
    <title>About Us</title>
</head>
<body class="bg-light">

<?php
  include('../partials/navbar.php');
?>

    <!-- Hero Section -->
    <section class="bg-gradient-primary text-white py-5" style="background: linear-gradient(135deg, #007bff 0%, #0056b3 100%);">
        <div class="container">
            <div class="row">
                <div class="col-12 text-center">
                    <h1 class="display-4 fw-bold mb-3">
                        <i class="fas fa-users me-3"></i>About Us
                    </h1>
                    <p class="lead">Learn more about ManualLK and our mission</p>
                </div>
            </div>
        </div>
    </section>

    <!-- Main Content -->
    <section class="py-5">
        <div class="container">
            <div class="row align-items-center g-5">
                <!-- About Content -->
                <div class="col-lg-8">
                    <div class="card border-0 shadow-lg rounded-4 h-100">
                        <div class="card-body p-5">
                            <div class="d-flex align-items-center mb-4">
                                <div class="bg-primary rounded-circle p-3 me-3">
                                    <i class="fas fa-info-circle fa-2x text-white"></i>
                                </div>
                                <h2 class="fw-bold text-primary mb-0">About ManualLK</h2>
                            </div>
                            
                            <div class="text-muted lh-lg">
                                <p class="mb-4">
                                    Welcome to <strong class="text-primary">ManualLK</strong>, your trusted platform for buying and selling vehicles. 
                                    Our mission is to connect buyers and sellers, providing a seamless and secure experience for all users. 
                                    Whether you are looking for a brand-new car, a pre-owned vehicle, or want to sell your own, 
                                    we make the process simple and efficient.
                                </p>
                                
                                <p class="mb-4">
                                    With a user-friendly interface and advanced search options, we ensure that you find the perfect vehicle 
                                    that fits your needs and budget. Our team is committed to maintaining transparency, security, 
                                    and customer satisfaction.
                                </p>
                                
                                <p class="mb-0">
                                    <strong class="text-success">Join us today and experience hassle-free vehicle trading like never before!</strong>
                                </p>
                            </div>

                            <!-- Features -->
                            <div class="row mt-5 g-3">
                                <div class="col-md-6">
                                    <div class="d-flex align-items-center">
                                        <div class="bg-success rounded-circle p-2 me-3">
                                            <i class="fas fa-shield-alt text-white"></i>
                                        </div>
                                        <div>
                                            <h6 class="mb-0 fw-bold">Secure Platform</h6>
                                            <small class="text-muted">Safe & trusted transactions</small>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="d-flex align-items-center">
                                        <div class="bg-warning rounded-circle p-2 me-3">
                                            <i class="fas fa-search text-white"></i>
                                        </div>
                                        <div>
                                            <h6 class="mb-0 fw-bold">Advanced Search</h6>
                                            <small class="text-muted">Find exactly what you need</small>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="d-flex align-items-center">
                                        <div class="bg-info rounded-circle p-2 me-3">
                                            <i class="fas fa-handshake text-white"></i>
                                        </div>
                                        <div>
                                            <h6 class="mb-0 fw-bold">Easy Connection</h6>
                                            <small class="text-muted">Connect buyers & sellers seamlessly</small>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="d-flex align-items-center">
                                        <div class="bg-danger rounded-circle p-2 me-3">
                                            <i class="fas fa-heart text-white"></i>
                                        </div>
                                        <div>
                                            <h6 class="mb-0 fw-bold">Customer First</h6>
                                            <small class="text-muted">Your satisfaction is our priority</small>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Developer Card -->
                <div class="col-lg-4">
                    <div class="card border-0 shadow-lg rounded-4 overflow-hidden hover-lift">
                        <div class="position-relative">
                            <img src="../assets/images/ai.jpg" class="card-img-top" alt="Awishka Isuru" style="height: 300px; object-fit: cover;">
                            <div class="position-absolute top-0 start-0 w-100 h-100 bg-gradient-dark opacity-25"></div>
                        </div>
                        
                        <div class="card-body text-center p-4">
                            <div class="mb-3">
                                <h4 class="fw-bold text-primary mb-1">Awishka Isuru</h4>
                                <span class="badge bg-primary rounded-pill px-3 py-2">
                                    <i class="fas fa-code me-1"></i>Full Stack Developer
                                </span>
                            </div>
                            
                            <div class="d-flex flex-column gap-3">
                                <div class="d-flex align-items-center justify-content-center">
                                    <div class="bg-success rounded-circle p-2 me-3">
                                        <i class="fas fa-phone text-white"></i>
                                    </div>
                                    <div class="text-start">
                                        <small class="text-muted d-block">Phone</small>
                                        <span class="fw-semibold">0701224436</span>
                                    </div>
                                </div>
                                
                                <div class="d-flex align-items-center justify-content-center">
                                    <div class="bg-primary rounded-circle p-2 me-3">
                                        <i class="fas fa-envelope text-white"></i>
                                    </div>
                                    <div class="text-start">
                                        <small class="text-muted d-block">Email</small>
                                        <a href="mailto:awishkaisuru0573@gmail.com" class="text-decoration-none fw-semibold text-primary">
                                            awishkaisuru0573@gmail.com
                                        </a>
                                    </div>
                                </div>
                            </div>

                            <!-- Contact Button -->
                            <div class="mt-4">
                                <button type="button" class="btn btn-outline-primary btn-sm px-4 rounded-pill" onclick="contactDeveloper()">
                                    <i class="fas fa-paper-plane me-1"></i>Get In Touch
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Stats Section -->
    <section class="py-5 bg-white">
        <div class="container">
            <div class="row text-center g-4">
                <div class="col-6 col-md-3">
                    <div class="card border-0 h-100 bg-primary text-white rounded-4 shadow">
                        <div class="card-body p-4">
                            <i class="fas fa-car fa-3x mb-3"></i>
                            <h3 class="fw-bold">1000+</h3>
                            <p class="mb-0">Vehicles Listed</p>
                        </div>
                    </div>
                </div>
                <div class="col-6 col-md-3">
                    <div class="card border-0 h-100 bg-success text-white rounded-4 shadow">
                        <div class="card-body p-4">
                            <i class="fas fa-users fa-3x mb-3"></i>
                            <h3 class="fw-bold">500+</h3>
                            <p class="mb-0">Happy Customers</p>
                        </div>
                    </div>
                </div>
                <div class="col-6 col-md-3">
                    <div class="card border-0 h-100 bg-warning text-white rounded-4 shadow">
                        <div class="card-body p-4">
                            <i class="fas fa-handshake fa-3x mb-3"></i>
                            <h3 class="fw-bold">300+</h3>
                            <p class="mb-0">Successful Deals</p>
                        </div>
                    </div>
                </div>
                <div class="col-6 col-md-3">
                    <div class="card border-0 h-100 bg-info text-white rounded-4 shadow">
                        <div class="card-body p-4">
                            <i class="fas fa-star fa-3x mb-3"></i>
                            <h3 class="fw-bold">4.8</h3>
                            <p class="mb-0">Average Rating</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Mission & Vision -->
    <section class="py-5 bg-light">
        <div class="container">
            <div class="row g-4">
                <div class="col-md-6">
                    <div class="card border-0 shadow-sm rounded-4 h-100">
                        <div class="card-body p-5 text-center">
                            <div class="bg-primary rounded-circle d-inline-flex align-items-center justify-content-center mb-4" style="width: 80px; height: 80px;">
                                <i class="fas fa-bullseye fa-2x text-white"></i>
                            </div>
                            <h3 class="fw-bold text-primary mb-3">Our Mission</h3>
                            <p class="text-muted lh-lg">
                                To revolutionize the vehicle trading experience in Sri Lanka by providing a secure, 
                                user-friendly platform that connects buyers and sellers efficiently while maintaining 
                                the highest standards of transparency and customer satisfaction.
                            </p>
                        </div>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="card border-0 shadow-sm rounded-4 h-100">
                        <div class="card-body p-5 text-center">
                            <div class="bg-success rounded-circle d-inline-flex align-items-center justify-content-center mb-4" style="width: 80px; height: 80px;">
                                <i class="fas fa-eye fa-2x text-white"></i>
                            </div>
                            <h3 class="fw-bold text-success mb-3">Our Vision</h3>
                            <p class="text-muted lh-lg">
                                To become Sri Lanka's leading vehicle marketplace, known for innovation, reliability, 
                                and exceptional service. We envision a future where buying and selling vehicles 
                                is as simple as a few clicks, with complete peace of mind.
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

<?php
    include('../partials/footer.php');
?>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <!-- SweetAlert2 -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11.7.32/dist/sweetalert2.all.min.js"></script>
    
    <script>
        // Smooth scrolling
        document.documentElement.style.scrollBehavior = "smooth";
        
        // Add hover effects for cards
        document.addEventListener('DOMContentLoaded', function() {
            const cards = document.querySelectorAll('.hover-lift');
            cards.forEach(card => {
                card.addEventListener('mouseenter', function() {
                    this.style.transform = 'translateY(-10px)';
                    this.style.transition = 'transform 0.3s ease';
                });
                card.addEventListener('mouseleave', function() {
                    this.style.transform = 'translateY(0)';
                });
            });
        });

        // Contact Developer Function with SweetAlert
        function contactDeveloper() {
            Swal.fire({
                title: 'Contact Developer',
                html: `
                    <div class="text-start">
                        <p class="mb-3"><strong>Awishka Isuru</strong> - Full Stack Developer</p>
                        <p class="mb-2">
                            <i class="fas fa-phone text-success me-2"></i>
                            <a href="tel:0701224436" class="text-decoration-none">0701224436</a>
                        </p>
                        <p class="mb-2">
                            <i class="fas fa-envelope text-primary me-2"></i>
                            <a href="mailto:awishkaisuru0573@gmail.com" class="text-decoration-none">awishkaisuru0573@gmail.com</a>
                        </p>
                    </div>
                `,
                icon: 'info',
                showCancelButton: true,
                confirmButtonText: '<i class="fas fa-envelope me-1"></i> Send Email',
                cancelButtonText: '<i class="fas fa-phone me-1"></i> Call Now',
                confirmButtonColor: '#007bff',
                cancelButtonColor: '#28a745',
                reverseButtons: true
            }).then((result) => {
                if (result.isConfirmed) {
                    // Send Email
                    window.location.href = 'mailto:awishkaisuru0573@gmail.com?subject=Inquiry from ManualLK About Page&body=Hello Awishka,%0D%0A%0D%0AI visited your About page on ManualLK and would like to get in touch.%0D%0A%0D%0ARegards';
                } else if (result.dismiss === Swal.DismissReason.cancel) {
                    // Make Phone Call
                    window.location.href = 'tel:0701224436';
                }
            });
        }

        // Welcome animation
        window.addEventListener('load', function() {
            // Add fade-in animation to cards
            const cards = document.querySelectorAll('.card');
            cards.forEach((card, index) => {
                card.style.opacity = '0';
                card.style.transform = 'translateY(30px)';
                card.style.transition = 'opacity 0.6s ease, transform 0.6s ease';
                
                setTimeout(() => {
                    card.style.opacity = '1';
                    card.style.transform = 'translateY(0)';
                }, index * 100);
            });
        });

        // Show success message if coming from contact form
        const urlParams = new URLSearchParams(window.location.search);
        if (urlParams.get('success') === '1') {
            Swal.fire({
                title: 'Thank You!',
                text: 'Your message has been sent successfully. We will get back to you soon!',
                icon: 'success',
                confirmButtonColor: '#007bff'
            });
        }
    </script>
</body>
</html>