<?php
session_start();
include('../includes/dbconnect.php');

$success = false;
$error = false;

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = mysqli_real_escape_string($conn, $_POST['fname']);
    $email = mysqli_real_escape_string($conn, $_POST['email']);
    $message = mysqli_real_escape_string($conn, $_POST['message']);
    
    // Get user_id from session if user is logged in
    $user_id = isset($_SESSION['user_id']) ? $_SESSION['user_id'] : NULL;
    
    $sql = "INSERT INTO feedback (user_id, name, email, message) VALUES (?, ?, ?, ?)";
    $stmt = mysqli_prepare($conn, $sql);
    mysqli_stmt_bind_param($stmt, "isss", $user_id, $name, $email, $message);
    
    if (mysqli_stmt_execute($stmt)) {
        $success = true;
    } else {
        $error = true;
    }
    
    mysqli_stmt_close($stmt);
}
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
    <title>Contact Us</title>
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
                        <i class="fas fa-envelope me-3"></i>Contact Us
                    </h1>
                    <p class="lead">We'd love to hear from you. Get in touch with us!</p>
                </div>
            </div>
        </div>
    </section>

    <!-- Main Content -->
    <section class="py-5">
        <div class="container">
            <div class="row g-5">
                <!-- Contact Information -->
                <div class="col-lg-5">
                    <div class="card border-0 shadow-lg rounded-4 h-100">
                        <div class="card-body p-5">
                            <h2 class="fw-bold text-primary mb-4">
                                <i class="fas fa-map-marker-alt me-2"></i>Get In Touch
                            </h2>
                            <p class="text-muted mb-5">Feel free to reach out to us through any of the following methods:</p>
                            
                            <!-- Address -->
                            <div class="d-flex align-items-start mb-4">
                                <div class="bg-primary rounded-circle p-3 me-4 flex-shrink-0">
                                    <i class="fas fa-home fa-lg text-white"></i>
                                </div>
                                <div>
                                    <h5 class="fw-bold text-dark mb-2">Address</h5>
                                    <p class="text-muted mb-0">No.01, Bandaranayaka mw,<br>Ballapana Galigamuwa Town.</p>
                                </div>
                            </div>

                            <!-- Phone -->
                            <div class="d-flex align-items-start mb-4">
                                <div class="bg-success rounded-circle p-3 me-4 flex-shrink-0">
                                    <i class="fas fa-phone fa-lg text-white"></i>
                                </div>
                                <div>
                                    <h5 class="fw-bold text-dark mb-2">Contact</h5>
                                    <p class="text-muted mb-0">
                                        <a href="tel:0701224436" class="text-decoration-none text-success fw-semibold">0701224436</a>
                                    </p>
                                </div>
                            </div>

                            <!-- Email -->
                            <div class="d-flex align-items-start mb-4">
                                <div class="bg-info rounded-circle p-3 me-4 flex-shrink-0">
                                    <i class="fas fa-envelope fa-lg text-white"></i>
                                </div>
                                <div>
                                    <h5 class="fw-bold text-dark mb-2">Email</h5>
                                    <p class="text-muted mb-0">
                                        <a href="mailto:awishkaisuru0573@gmail.com" class="text-decoration-none text-info fw-semibold">awishkaisuru0573@gmail.com</a>
                                    </p>
                                </div>
                            </div>

                            <!-- Quick Actions -->
                            <div class="row g-3 mt-4">
                                <div class="col-6">
                                    <a href="tel:0701224436" class="btn btn-success w-100 rounded-pill">
                                        <i class="fas fa-phone me-1"></i>Call Now
                                    </a>
                                </div>
                                <div class="col-6">
                                    <a href="mailto:awishkaisuru0573@gmail.com" class="btn btn-info w-100 rounded-pill text-white">
                                        <i class="fas fa-envelope me-1"></i>Send Email
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Contact Form -->
                <div class="col-lg-7">
                    <div class="card border-0 shadow-lg rounded-4 h-100">
                        <div class="card-body p-5">
                            <h2 class="fw-bold text-primary mb-4">
                                <i class="fas fa-paper-plane me-2"></i>Send Us a Message
                            </h2>
                            
                            <?php if (!isset($_SESSION['user_id'])): ?>
                                <div class="alert alert-info d-flex align-items-center mb-4" role="alert">
                                    <i class="fas fa-info-circle me-2"></i>
                                    <div>
                                        Please <a href="../pages/signin.php" class="alert-link fw-bold">sign in</a> to send us a message with your account details.
                                    </div>
                                </div>
                            <?php endif; ?>

                            <form action="#" method="post" id="contactForm">
                                <!-- Name Field -->
                                <div class="mb-4">
                                    <label for="fname" class="form-label fw-semibold">
                                        <i class="fas fa-user text-primary me-2"></i>Name
                                    </label>
                                    <input type="text" 
                                           class="form-control form-control-lg rounded-3 border-2" 
                                           id="fname" 
                                           name="fname" 
                                           value="<?php echo isset($_SESSION['name']) ? htmlspecialchars($_SESSION['name']) : ''; ?>" 
                                           readonly
                                           placeholder="<?php echo isset($_SESSION['name']) ? '' : 'Please sign in to auto-fill'; ?>">
                                </div>

                                <!-- Email Field -->
                                <div class="mb-4">
                                    <label for="email" class="form-label fw-semibold">
                                        <i class="fas fa-envelope text-primary me-2"></i>Email Address
                                    </label>
                                    <input type="email" 
                                           class="form-control form-control-lg rounded-3 border-2" 
                                           id="email" 
                                           name="email" 
                                           value="<?php echo isset($_SESSION['email']) ? htmlspecialchars($_SESSION['email']) : ''; ?>" 
                                           readonly
                                           placeholder="<?php echo isset($_SESSION['email']) ? '' : 'Please sign in to auto-fill'; ?>">
                                </div>

                                <!-- Message Field -->
                                <div class="mb-4">
                                    <label for="message" class="form-label fw-semibold">
                                        <i class="fas fa-comment text-primary me-2"></i>Message
                                    </label>
                                    <textarea class="form-control form-control-lg rounded-3 border-2" 
                                              id="message" 
                                              name="message" 
                                              rows="6" 
                                              required 
                                              placeholder="Write your message here..."></textarea>
                                </div>

                                <!-- Submit Button -->
                                <div class="d-grid">
                                    <button type="submit" 
                                            class="btn btn-primary btn-lg rounded-pill fw-bold"
                                            <?php echo !isset($_SESSION['user_id']) ? 'disabled' : ''; ?>>
                                        <i class="fas fa-paper-plane me-2"></i>
                                        <?php echo isset($_SESSION['user_id']) ? 'Send Message' : 'Sign In Required'; ?>
                                    </button>
                                </div>

                                <?php if (!isset($_SESSION['user_id'])): ?>
                                    <div class="text-center mt-3">
                                        <a href="../pages/signin.php" class="btn btn-outline-primary rounded-pill px-4">
                                            <i class="fas fa-sign-in-alt me-1"></i>Sign In Now
                                        </a>
                                    </div>
                                <?php endif; ?>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Additional Info Section -->
    <section class="py-5 bg-white">
        <div class="container">
            <div class="row text-center g-4">
                <div class="col-md-4">
                    <div class="card border-0 h-100 shadow-sm rounded-4">
                        <div class="card-body p-4">
                            <div class="bg-primary rounded-circle d-inline-flex align-items-center justify-content-center mb-3" style="width: 60px; height: 60px;">
                                <i class="fas fa-clock fa-lg text-white"></i>
                            </div>
                            <h5 class="fw-bold text-primary">Response Time</h5>
                            <p class="text-muted mb-0">We typically respond within 24 hours</p>
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="card border-0 h-100 shadow-sm rounded-4">
                        <div class="card-body p-4">
                            <div class="bg-success rounded-circle d-inline-flex align-items-center justify-content-center mb-3" style="width: 60px; height: 60px;">
                                <i class="fas fa-headset fa-lg text-white"></i>
                            </div>
                            <h5 class="fw-bold text-success">Support</h5>
                            <p class="text-muted mb-0">Dedicated customer support team</p>
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="card border-0 h-100 shadow-sm rounded-4">
                        <div class="card-body p-4">
                            <div class="bg-info rounded-circle d-inline-flex align-items-center justify-content-center mb-3" style="width: 60px; height: 60px;">
                                <i class="fas fa-shield-alt fa-lg text-white"></i>
                            </div>
                            <h5 class="fw-bold text-info">Privacy</h5>
                            <p class="text-muted mb-0">Your information is safe with us</p>
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

        // Show success/error alerts using SweetAlert2
        <?php if ($success): ?>
            Swal.fire({
                title: 'Thank You!',
                text: 'Your feedback has been submitted successfully. We will get back to you soon!',
                icon: 'success',
                confirmButtonText: 'Great!',
                confirmButtonColor: '#007bff',
                timer: 5000,
                timerProgressBar: true
            });
        <?php endif; ?>

        <?php if ($error): ?>
            Swal.fire({
                title: 'Oops!',
                text: 'Unable to submit feedback. Please try again later.',
                icon: 'error',
                confirmButtonText: 'Try Again',
                confirmButtonColor: '#dc3545'
            });
        <?php endif; ?>

        // Form validation
        document.getElementById('contactForm').addEventListener('submit', function(e) {
            const message = document.getElementById('message').value.trim();
            
            if (message === '') {
                e.preventDefault();
                Swal.fire({
                    title: 'Message Required',
                    text: 'Please enter your message before submitting.',
                    icon: 'warning',
                    confirmButtonColor: '#007bff'
                });
                return false;
            }

            // Show loading state
            const submitBtn = this.querySelector('button[type="submit"]');
            const originalText = submitBtn.innerHTML;
            submitBtn.innerHTML = '<i class="fas fa-spinner fa-spin me-2"></i>Sending...';
            submitBtn.disabled = true;

            // Re-enable button after 3 seconds (in case of slow response)
            setTimeout(() => {
                submitBtn.innerHTML = originalText;
                submitBtn.disabled = false;
            }, 3000);
        });

        // Add fade-in animation
        window.addEventListener('load', function() {
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

        // Contact method selection
        function selectContactMethod() {
            Swal.fire({
                title: 'How would you like to contact us?',
                showDenyButton: true,
                showCancelButton: true,
                confirmButtonText: '<i class="fas fa-phone me-1"></i> Call',
                denyButtonText: '<i class="fas fa-envelope me-1"></i> Email',
                cancelButtonText: 'Cancel',
                confirmButtonColor: '#28a745',
                denyButtonColor: '#007bff'
            }).then((result) => {
                if (result.isConfirmed) {
                    window.location.href = 'tel:0701224436';
                } else if (result.isDenied) {
                    window.location.href = 'mailto:awishkaisuru0573@gmail.com?subject=Inquiry from ManualLK Contact Page&body=Hello,%0D%0A%0D%0AI would like to inquire about...%0D%0A%0D%0ARegards';
                }
            });
        }

        // Character counter for message
        const messageTextarea = document.getElementById('message');
        if (messageTextarea) {
            const maxLength = 1000;
            const counterDiv = document.createElement('div');
            counterDiv.className = 'text-muted small mt-1';
            counterDiv.innerHTML = `<span id="charCount">0</span>/${maxLength} characters`;
            messageTextarea.parentNode.appendChild(counterDiv);

            messageTextarea.addEventListener('input', function() {
                const currentLength = this.value.length;
                document.getElementById('charCount').textContent = currentLength;
                
                if (currentLength > maxLength * 0.9) {
                    counterDiv.className = 'text-warning small mt-1';
                } else {
                    counterDiv.className = 'text-muted small mt-1';
                }
            });
        }
    </script>
</body>
</html>