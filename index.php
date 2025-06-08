<?php
session_start();
include_once './includes/dbconnect.php';

// Fetch active feedback for testimonials
$testimonialSql = "SELECT * FROM feedback WHERE status = 'active' ORDER BY feedback_id DESC LIMIT 6";
$testimonialResult = $conn->query($testimonialSql);
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
  <title>ManualLK</title>
  <link rel="icon" type="image/png" href="./assets/images/logo-w.png">
</head>

<body class="bg-light">
  <!-- Navigation -->
  <nav class="navbar navbar-expand-lg navbar-dark bg-primary shadow-sm sticky-top">
    <div class="container">
      <!-- Logo -->
      <a class="navbar-brand d-flex align-items-center fw-bold fs-4" href="#">
        <img src="assets/images/logo-w.png" alt="Logo" width="40" height="40" class="me-2">
        ManualLK
      </a>
      
      <!-- Mobile Toggle -->
      <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
        <span class="navbar-toggler-icon"></span>
      </button>
      
      <!-- Navigation Links -->
      <div class="collapse navbar-collapse" id="navbarNav">
        <ul class="navbar-nav ms-auto">
          <li class="nav-item">
            <a class="nav-link active" href="#">
              <i class="fas fa-home me-1"></i>Home
            </a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="pages/find.php">
              <i class="fas fa-search me-1"></i>Find
            </a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="pages/aboutus.php">
              <i class="fas fa-info-circle me-1"></i>About
            </a>
          </li>
          <?php if (!isset($_SESSION['user_id'])): ?>
            <li class="nav-item">
              <a class="nav-link" href="pages/signin.php">
                <i class="fas fa-envelope me-1"></i>Contact
              </a>
            </li>
            <li class="nav-item">
              <a class="nav-link btn btn-outline-light ms-2 px-3" href="pages/signin.php">
                <i class="fas fa-sign-in-alt me-1"></i>SignIn
              </a>
            </li>
          <?php endif; ?>
          <?php if (isset($_SESSION['user_id'])): ?>
            <li class="nav-item">
              <a class="nav-link" href="pages/contactus.php">
                <i class="fas fa-envelope me-1"></i>Contact
              </a>
            </li>
            <li class="nav-item">
              <a class="nav-link btn btn-outline-light ms-2 px-3" href="./pages/logout.php">
                <i class="fas fa-sign-out-alt me-1"></i>Logout
              </a>
            </li>
          <?php endif; ?>
          <?php if (isset($_SESSION['user_id']) && $_SESSION['role'] === 'admin'): ?>
            <li class="nav-item">
              <a class="nav-link btn btn-warning ms-2 px-3 text-dark" href="./pages/admin/index.php">
                <i class="fas fa-cog me-1"></i>Admin
              </a>
            </li>
          <?php endif; ?>
        </ul>
      </div>
    </div>
  </nav>

  <!-- Hero Section -->
  <section class="bg-gradient-primary text-white py-5" style="background: linear-gradient(135deg, #007bff 0%, #0056b3 100%);">
    <div class="container">
      <div class="row align-items-center min-vh-50">
        <div class="col-lg-8 mx-auto text-center">
          <div class="card bg-white bg-opacity-10 backdrop-blur border-0 shadow-lg p-5 rounded-4">
            <h1 class="display-4 fw-bold mb-4">
              Welcome
              <span class="text-warning">
                <?php
                if (isset($_SESSION['user_id']) && isset($_SESSION['name'])) {
                  echo htmlspecialchars($_SESSION['name']);
                } else {
                  echo "Home";
                }
                ?>!
              </span>
            </h1>
            <?php if (!isset($_SESSION['user_id'])): ?>
              <a href="pages/find.php" class="btn btn-warning btn-lg px-5 py-3 fw-bold rounded-pill shadow">
                <i class="fas fa-rocket me-2"></i>Start Here
              </a>
            <?php endif; ?>
          </div>
        </div>
      </div>
    </div>
  </section>

  <!-- Welcome Section -->
  <section class="py-5">
    <div class="container">
      <div class="row">
        <div class="col-lg-10 mx-auto text-center">
          <div class="card border-0 shadow-sm rounded-4 p-4">
            <div class="card-body">
              <h2 class="fw-bold text-primary mb-4">Welcome to ManualLK</h2>
              <p class="lead text-muted">
                Sri Lanka's largest vehicle marketplace. Whether you're looking to buy or sell, we offer a wide range of vehicles at affordable prices.<br><br>
                Our platform connects buyers and sellers seamlessly, ensuring a hassle-free experience. Start your journey today and find the perfect vehicle to match your needs.
              </p>
            </div>
          </div>
        </div>
      </div>
    </div>
  </section>

  <!-- Vehicle Brands -->
<section class="py-5 bg-white">
  <div class="container">
    <h3 class="text-center fw-bold text-primary mb-5">Trusted Vehicle Brands</h3>
    <div class="row g-4">
      <div class="col-6 col-md-4 col-lg-2">
        <div class="card h-100 border-0 shadow-sm rounded-3 overflow-hidden hover-lift">
          <img src="./assets/images/toyota.jpg" class="card-img-top" alt="Toyota" style="height: 120px; object-fit: contain; padding: 15px;">
        </div>
      </div>
      <div class="col-6 col-md-4 col-lg-2">
        <div class="card h-100 border-0 shadow-sm rounded-3 overflow-hidden hover-lift">
          <img src="./assets/images/bense.jpg" class="card-img-top" alt="Mercedes" style="height: 120px; object-fit: contain; padding: 15px;">
        </div>
      </div>
      <div class="col-6 col-md-4 col-lg-2">
        <div class="card h-100 border-0 shadow-sm rounded-3 overflow-hidden hover-lift">
          <img src="./assets/images/bmw.jpg" class="card-img-top" alt="BMW" style="height: 120px; object-fit: contain; padding: 15px;">
        </div>
      </div>
      <div class="col-6 col-md-4 col-lg-2">
        <div class="card h-100 border-0 shadow-sm rounded-3 overflow-hidden hover-lift">
          <img src="./assets/images/nissan.jpg" class="card-img-top" alt="Nissan" style="height: 120px; object-fit: contain; padding: 15px;">
        </div>
      </div>
      <div class="col-6 col-md-4 col-lg-2">
        <div class="card h-100 border-0 shadow-sm rounded-3 overflow-hidden hover-lift">
          <img src="./assets/images/suzuki.jpg" class="card-img-top" alt="Suzuki" style="height: 120px; object-fit: contain; padding: 15px;">
        </div>
      </div>
      <div class="col-6 col-md-4 col-lg-2">
        <div class="card h-100 border-0 shadow-sm rounded-3 overflow-hidden hover-lift">
          <img src="./assets/images/honda.jpg" class="card-img-top" alt="Honda" style="height: 120px; object-fit: contain; padding: 15px;">
        </div>
      </div>
    </div>
    <div class="row justify-content-center mt-4">
      <div class="col-6 col-md-4 col-lg-2">
        <div class="card h-100 border-0 shadow-sm rounded-3 overflow-hidden hover-lift">
          <img src="./assets/images/ISUZU-logo.jpg" class="card-img-top" alt="Isuzu" style="height: 120px; object-fit: contain; padding: 15px;">
        </div>
      </div>
    </div>
  </div>
</section>

  <!-- Buy/Sell Buttons -->
  <!-- Buy/Sell Buttons -->
<section class="py-5 bg-light">
  <div class="container">
    <div class="row g-4">
      <div class="col-md-6">
        <div class="card border-0 shadow-lg h-100 rounded-4 overflow-hidden">
          <div class="card-body text-center p-5 bg-success text-white">
            <i class="fas fa-dollar-sign fa-3x mb-3"></i>
            <h4 class="fw-bold mb-3">Ready to Buy?</h4>
            <p class="mb-4">Find your perfect vehicle from thousands of listings</p>
            <a href="pages/find.php" class="btn btn-light btn-lg px-5 fw-bold rounded-pill text-success">
              <i class="fas fa-search me-2"></i>Buy Your Vehicle
            </a>
          </div>
        </div>
      </div>
      <div class="col-md-6">
        <div class="card border-0 shadow-lg h-100 rounded-4 overflow-hidden">
          <div class="card-body text-center p-5 bg-warning text-dark">
            <i class="fas fa-dollar-sign fa-3x mb-3"></i>
            <h4 class="fw-bold mb-3">Want to Sell?</h4>
            <p class="mb-4">List your vehicle and reach thousands of buyers</p>
            <?php if (isset($_SESSION['user_id'])): ?>
              <a href="./pages/sell.php" class="btn btn-dark btn-lg px-5 fw-bold rounded-pill">
                <i class="fas fa-plus me-2"></i>Sell Your Vehicle
              </a>
            <?php else: ?>
              <a href="./pages/signin.php" class="btn btn-dark btn-lg px-5 fw-bold rounded-pill">
                <i class="fas fa-plus me-2"></i>Sell Your Vehicle
              </a>
            <?php endif; ?>
          </div>
        </div>
      </div>
    </div>
  </div>
</section>

  <!-- Popular Vehicles -->
  <section class="py-5 bg-white">
    <div class="container">
      <h3 class="text-center fw-bold text-primary mb-5">Sri Lankan's Most Popular</h3>
      <div class="row g-4">
        <div class="col-sm-6 col-lg-3">
          <div class="card h-100 border-0 shadow-sm rounded-4 overflow-hidden hover-lift">
            <img src="./assets/images/ct100.png" class="card-img-top" alt="CT100" style="height: 200px; object-fit: cover;">
            <div class="card-body text-center">
              <h5 class="card-title fw-bold text-primary">CT100</h5>
              <p class="card-text text-muted">Bajaj 100cc</p>
            </div>
          </div>
        </div>
        <div class="col-sm-6 col-lg-3">
          <div class="card h-100 border-0 shadow-sm rounded-4 overflow-hidden hover-lift">
            <img src="./assets/images/3weel.png" class="card-img-top" alt="Three Wheeler" style="height: 200px; object-fit: cover;">
            <div class="card-body text-center">
              <h5 class="card-title fw-bold text-primary">Three Wheeler</h5>
              <p class="card-text text-muted">Bajaj re205</p>
            </div>
          </div>
        </div>
        <div class="col-sm-6 col-lg-3">
          <div class="card h-100 border-0 shadow-sm rounded-4 overflow-hidden hover-lift">
            <img src="./assets/images/alto.png" class="card-img-top" alt="Alto" style="height: 200px; object-fit: cover;">
            <div class="card-body text-center">
              <h5 class="card-title fw-bold text-primary">Alto</h5>
              <p class="card-text text-muted">Suzuki 800cc</p>
            </div>
          </div>
        </div>
        <div class="col-sm-6 col-lg-3">
          <div class="card h-100 border-0 shadow-sm rounded-4 overflow-hidden hover-lift">
            <img src="./assets/images/kdh.png" class="card-img-top" alt="KDH" style="height: 200px; object-fit: cover;">
            <div class="card-body text-center">
              <h5 class="card-title fw-bold text-primary">KDH</h5>
              <p class="card-text text-muted">Toyota 2500cc</p>
            </div>
          </div>
        </div>
      </div>
    </div>
  </section>

  <!-- About Section -->
  <section class="py-5 bg-light">
    <div class="container">
      <div class="row align-items-center g-5">
        <div class="col-lg-8">
          <div class="card border-0 shadow-sm rounded-4 h-100">
            <div class="card-body p-5">
              <h3 class="fw-bold text-primary mb-4">About Us</h3>
              <p class="text-muted lh-lg">
                Welcome to ManualLK, your trusted platform for buying and selling vehicles. Our mission is to connect buyers and sellers, providing a seamless and secure experience for all users. Whether you are looking for a brand-new car, a pre-owned vehicle, or want to sell your own, we make the process simple and efficient.
              </p>
              <p class="text-muted lh-lg">
                With a user-friendly interface and advanced search options, we ensure that you find the perfect vehicle that fits your needs and budget. Our team is committed to maintaining transparency, security, and customer satisfaction. Join us today and experience hassle-free vehicle trading like never before!
              </p>
            </div>
          </div>
        </div>
        <div class="col-lg-4">
          <div class="card border-0 shadow-lg rounded-4 overflow-hidden">
            <img src="./assets/images/ai.jpg" class="card-img-top" alt="Awishka Isuru" style="height: 250px; object-fit: cover;">
            <div class="card-body text-center p-4">
              <h5 class="card-title fw-bold text-primary">Awishka Isuru</h5>
              <p class="card-text text-muted mb-3">Full Stack Developer</p>
              <div class="d-flex flex-column gap-2">
                <span class="text-muted">
                  <i class="fas fa-phone text-primary me-2"></i>0701224436
                </span>
                <a href="mailto:awishkaisuru0573@gmail.com" class="text-decoration-none">
                  <i class="fas fa-envelope text-primary me-2"></i>awishkaisuru0573@gmail.com
                </a>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </section>
  <!-- Testimonial Section -->
                <section class="container mb-5">
    <div class="card shadow-sm border-0">
      <div class="card-header bg-primary text-white">
        <h5 class="mb-0">What Our Users Say</h5>
      </div>
      <div class="card-body">
        <div class="row">
          <?php if ($testimonialResult && $testimonialResult->num_rows > 0): ?>
            <?php while($testimonial = $testimonialResult->fetch_assoc()): ?>
              <div class="col-md-4 mb-3">
                <div class="border rounded p-3 h-100 bg-light">
                  <p class="mb-1"><i class="fas fa-quote-left text-primary"></i> <?php echo htmlspecialchars($testimonial['message']); ?></p>
                  <div class="text-end">
                    <small class="text-muted">- <?php echo htmlspecialchars($testimonial['name'] ?? 'Anonymous'); ?></small>
                  </div>
                </div>
              </div>
            <?php endwhile; ?>
          <?php else: ?>
            <div class="col-12 text-center text-muted">No testimonials available.</div>
          <?php endif; ?>
        </div>
      </div>
    </div>
  </section>
  <!-- End Testimonial Section -->
  <?php include('./partials/footer.php'); ?>


  


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
          this.style.transform = 'translateY(-5px)';
          this.style.transition = 'transform 0.3s ease';
        });
        card.addEventListener('mouseleave', function() {
          this.style.transform = 'translateY(0)';
        });
      });
    });

    // Example SweetAlert usage (you can customize this for your alerts)
    function showWelcomeAlert() {
      Swal.fire({
        title: 'Welcome to ManualLK!',
        text: 'Find your perfect vehicle today',
        icon: 'success',
        confirmButtonText: 'Get Started',
        confirmButtonColor: '#007bff'
      });
    }
    
    // Uncomment the line below if you want to show welcome alert on page load
    // showWelcomeAlert();
  </script>
</body>

</html>