<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ManualLK Footer</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.2/css/bootstrap.min.css" rel="stylesheet">
    <!-- Font Awesome -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
    
    <style>
        footer {
            background: linear-gradient(135deg, #007bff 0%, #0056b3 100%);
            color: #fff;
            padding: 4rem 0 2rem 0;
            margin-top: 4rem;
            position: relative;
            overflow: hidden;
        }

        footer::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: url('data:image/svg+xml,<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 100 100"><defs><pattern id="grid" width="10" height="10" patternUnits="userSpaceOnUse"><path d="M 10 0 L 0 0 0 10" fill="none" stroke="rgba(255,255,255,0.1)" stroke-width="0.5"/></pattern></defs><rect width="100" height="100" fill="url(%23grid)"/></svg>');
            opacity: 0.3;
            pointer-events: none;
        }

        .footer-card {
            background: rgba(255, 255, 255, 0.1);
            backdrop-filter: blur(10px);
            border: 1px solid rgba(255, 255, 255, 0.2);
            border-radius: 1rem;
            padding: 2rem;
            height: 100%;
            transition: all 0.3s ease;
            position: relative;
            z-index: 1;
        }

        .footer-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 20px 40px rgba(0, 0, 0, 0.3);
            background: rgba(255, 255, 255, 0.15);
        }

        .footer-logo {
            font-size: 1.75rem;
            font-weight: bold;
            color: #ffc107;
            margin-bottom: 1rem;
            text-shadow: 2px 2px 4px rgba(0, 0, 0, 0.3);
        }

        .footer-logo img {
            filter: drop-shadow(2px 2px 4px rgba(0, 0, 0, 0.3));
        }

        .footer-links {
            list-style: none;
            padding: 0;
            margin: 0;
        }

        .footer-links li {
            margin-bottom: 0.75rem;
        }

        .footer-links a {
            color: rgba(255, 255, 255, 0.8);
            text-decoration: none;
            transition: all 0.3s ease;
            display: flex;
            align-items: center;
            padding: 0.25rem 0;
            border-radius: 0.25rem;
        }

        .footer-links a:hover {
            color: #ffc107;
            transform: translateX(8px);
            background: rgba(255, 193, 7, 0.1);
            padding-left: 0.5rem;
        }

        .footer-links a i {
            margin-right: 0.75rem;
            width: 20px;
            text-align: center;
            transition: all 0.3s ease;
        }

        .footer-links a:hover i {
            transform: scale(1.2);
            color: #ffc107;
        }

        .social-icons {
            display: flex;
            gap: 1rem;
            justify-content: center;
            margin-top: 1.5rem;
            flex-wrap: wrap;
        }

        .social-icons a {
            display: flex;
            align-items: center;
            justify-content: center;
            width: 50px;
            height: 50px;
            background: rgba(255, 255, 255, 0.1);
            border: 2px solid rgba(255, 255, 255, 0.2);
            border-radius: 50%;
            color: #fff;
            font-size: 1.3rem;
            text-decoration: none;
            transition: all 0.3s ease;
            position: relative;
            overflow: hidden;
        }

        .social-icons a::before {
            content: '';
            position: absolute;
            top: 0;
            left: -100%;
            width: 100%;
            height: 100%;
            background: linear-gradient(90deg, transparent, rgba(255, 255, 255, 0.2), transparent);
            transition: all 0.6s ease;
        }

        .social-icons a:hover::before {
            left: 100%;
        }

        .social-icons a:hover {
            background: #ffc107;
            color: #000;
            transform: translateY(-5px) scale(1.1);
            box-shadow: 0 8px 25px rgba(255, 193, 7, 0.4);
            border-color: #ffc107;
        }

        .footer-divider {
            border: none;
            height: 2px;
            background: linear-gradient(to right, transparent, rgba(255, 255, 255, 0.4), transparent);
            margin: 3rem 0 2rem 0;
            border-radius: 1px;
        }

        .footer-bottom {
            text-align: center;
            color: rgba(255, 255, 255, 0.8);
            font-size: 0.95rem;
            position: relative;
            z-index: 1;
        }

        .footer-bottom a {
            color: #ffc107;
            text-decoration: none;
            transition: all 0.3s ease;
            padding: 0.25rem 0.5rem;
            border-radius: 0.25rem;
        }

        .footer-bottom a:hover {
            color: #fff;
            background: rgba(255, 193, 7, 0.2);
            transform: translateY(-2px);
        }

        .contact-info {
            background: rgba(255, 255, 255, 0.08);
            border: 1px solid rgba(255, 255, 255, 0.1);
            border-radius: 0.75rem;
            padding: 1.5rem;
            margin-top: 1rem;
            transition: all 0.3s ease;
        }

        .contact-info:hover {
            background: rgba(255, 255, 255, 0.12);
            transform: translateY(-2px);
        }

        .contact-info p {
            margin-bottom: 0.75rem;
            display: flex;
            align-items: center;
            transition: all 0.3s ease;
        }

        .contact-info p:hover {
            transform: translateX(5px);
            color: #ffc107;
        }

        .contact-info i {
            margin-right: 0.75rem;
            color: #ffc107;
            width: 20px;
            text-align: center;
            font-size: 1.1rem;
        }

        .section-title {
            position: relative;
            margin-bottom: 2rem;
        }

        .section-title::after {
            content: '';
            position: absolute;
            bottom: -0.5rem;
            left: 0;
            width: 50px;
            height: 3px;
            background: linear-gradient(90deg, #ffc107, #ff9800);
            border-radius: 2px;
        }

        /* Responsive Design */
        @media (max-width: 1200px) {
            footer {
                padding: 3rem 0 2rem 0;
            }
            
            .footer-card {
                padding: 1.5rem;
            }
        }

        @media (max-width: 992px) {
            .footer-logo {
                font-size: 1.5rem;
            }
            
            .social-icons {
                justify-content: center;
                gap: 0.75rem;
            }
            
            .social-icons a {
                width: 45px;
                height: 45px;
                font-size: 1.2rem;
            }
        }

        @media (max-width: 768px) {
            footer {
                padding: 2.5rem 0 1.5rem 0;
                margin-top: 2rem;
            }
            
            .footer-card {
                margin-bottom: 2rem;
                padding: 1.25rem;
                text-align: center;
            }
            
            .footer-logo {
                font-size: 1.4rem;
                justify-content: center;
            }
            
            .section-title::after {
                left: 50%;
                transform: translateX(-50%);
            }
            
            .footer-links a {
                justify-content: center;
                text-align: center;
            }
            
            .contact-info p {
                justify-content: center;
                text-align: center;
            }
            
            .social-icons {
                gap: 0.5rem;
            }
            
            .social-icons a {
                width: 40px;
                height: 40px;
                font-size: 1.1rem;
            }
        }

        @media (max-width: 576px) {
            footer {
                padding: 2rem 0 1rem 0;
            }
            
            .footer-card {
                padding: 1rem;
                border-radius: 0.75rem;
            }
            
            .footer-logo {
                font-size: 1.3rem;
                margin-bottom: 0.75rem;
            }
            
            .footer-logo img {
                width: 30px;
                height: 30px;
            }
            
            .contact-info {
                padding: 1rem;
            }
            
            .footer-bottom {
                font-size: 0.85rem;
            }
            
            .footer-bottom .row > div {
                margin-bottom: 1rem;
            }
        }

        /* Animation for loading */
        @keyframes fadeInUp {
            from {
                opacity: 0;
                transform: translateY(30px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .footer-card {
            animation: fadeInUp 0.6s ease forwards;
        }

        .footer-card:nth-child(1) { animation-delay: 0.1s; }
        .footer-card:nth-child(2) { animation-delay: 0.2s; }
        .footer-card:nth-child(3) { animation-delay: 0.3s; }
        .footer-card:nth-child(4) { animation-delay: 0.4s; }
        .footer-card:nth-child(5) { animation-delay: 0.5s; }
    </style>
</head>
<body>
    <!-- Demo content to show footer at bottom -->
    <div style="min-height: 50vh; padding: 2rem;">
        <div class="container">
            <h1 class="text-center mb-4">ManualLK - Vehicle Marketplace</h1>
            <!-- <p class="text-center text-muted">This is demo content. Scroll down to see the responsive footer.</p> -->
        </div>
    </div>

    <footer class="mt-auto">
        <div class="container">
            <div class="row g-4">
                <!-- About Section -->
                <div class="col-xl-4 col-lg-4 col-md-6 col-sm-12">
                    <div class="footer-card">
                        <div class="footer-logo d-flex align-items-center">
                            <img src="assets/images/logo-w.png" alt="ManualLK Logo" width="35" height="35" class="me-2">
                            ManualLK
                        </div>
                        <p class="text-light mb-3">
                            Sri Lanka's premier vehicle marketplace connecting buyers and sellers across the island. 
                            Find your perfect vehicle or sell with confidence.
                        </p>
                        <div class="contact-info">
                            <p><i class="fas fa-phone"></i> <span>0701224436</span></p>
                            <p><i class="fas fa-envelope"></i> <span>awishkaisuru0573@gmail.com</span></p>
                            <p><i class="fas fa-map-marker-alt"></i> <span>Colombo, Sri Lanka</span></p>
                        </div>
                    </div>
                </div>

                <!-- Quick Links -->
                <div class="col-xl-2 col-lg-2 col-md-6 col-sm-6">
                    <div class="footer-card">
                        <h5 class="text-warning fw-bold mb-3 section-title">Quick Links</h5>
                        <ul class="footer-links">
                            <li><a href="#"><i class="fas fa-home"></i> <span>Home</span></a></li>
                            <li><a href="pages/find.php"><i class="fas fa-search"></i> <span>Find Vehicles</span></a></li>
                            <li><a href="pages/aboutus.php"><i class="fas fa-info-circle"></i> <span>About Us</span></a></li>
                            <li><a href="pages/contactus.php"><i class="fas fa-envelope"></i> <span>Contact</span></a></li>
                        </ul>
                    </div>
                </div>

                <!-- Services -->
                <div class="col-xl-2 col-lg-2 col-md-6 col-sm-6">
                    <div class="footer-card">
                        <h5 class="text-warning fw-bold mb-3 section-title">Services</h5>
                        <ul class="footer-links">
                            <li><a href="pages/find.php"><i class="fas fa-car"></i> <span>Buy Vehicles</span></a></li>
                            <li><a href="pages/sell.php"><i class="fas fa-tag"></i> <span>Sell Vehicles</span></a></li>
                            <li><a href="#"><i class="fas fa-tools"></i> <span>Vehicle Services</span></a></li>
                            <li><a href="#"><i class="fas fa-shield-alt"></i> <span>Insurance</span></a></li>
                        </ul>
                    </div>
                </div>

                <!-- Vehicle Types -->
                <div class="col-xl-2 col-lg-2 col-md-6 col-sm-6">
                    <div class="footer-card">
                        <h5 class="text-warning fw-bold mb-3 section-title">Categories</h5>
                        <ul class="footer-links">
                            <li><a href="#"><i class="fas fa-car"></i> <span>Cars</span></a></li>
                            <li><a href="#"><i class="fas fa-motorcycle"></i> <span>Motorcycles</span></a></li>
                            <li><a href="#"><i class="fas fa-truck"></i> <span>Commercial</span></a></li>
                            <li><a href="#"><i class="fas fa-bicycle"></i> <span>Three Wheelers</span></a></li>
                        </ul>
                    </div>
                </div>

                <!-- Connect With Us -->
                <div class="col-xl-2 col-lg-2 col-md-6 col-sm-6">
                    <div class="footer-card text-center">
                        <h5 class="text-warning fw-bold mb-3 section-title">Connect With Us</h5>
                        <p class="text-light mb-3">Follow us on social media for updates and deals</p>
                        <div class="social-icons">
                            <a href="#" title="Facebook" aria-label="Follow us on Facebook">
                                <i class="fab fa-facebook-f"></i>
                            </a>
                            <a href="#" title="Instagram" aria-label="Follow us on Instagram">
                                <i class="fab fa-instagram"></i>
                            </a>
                            <a href="#" title="Twitter" aria-label="Follow us on Twitter">
                                <i class="fab fa-twitter"></i>
                            </a>
                            <a href="#" title="YouTube" aria-label="Subscribe to our YouTube channel">
                                <i class="fab fa-youtube"></i>
                            </a>
                        </div>
                    </div>
                </div>
            </div>

            <hr class="footer-divider">
            
            <div class="footer-bottom">
                <div class="row align-items-center">
                    <div class="col-md-6 text-md-start text-center mb-3 mb-md-0">
                        <p class="mb-0">&copy; 2025 ManualLK. All rights reserved.</p>
                    </div>
                    <div class="col-md-6 text-md-end text-center">
                        <p class="mb-0">
                            <a href="#" class="me-3">Privacy Policy</a>
                            <a href="#">Terms of Service</a>
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </footer>

    <!-- Bootstrap JavaScript -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.2/js/bootstrap.bundle.min.js"></script>
</body>
</html>