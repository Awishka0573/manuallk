<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sign UP</title>
    <link rel="icon" type="image/png" href="../assets/images/logotransp.png">
    <!-- Bootstrap CSS -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.0/css/bootstrap.min.css" rel="stylesheet">
    <!-- Font Awesome for icons -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
    <!-- SweetAlert2 -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/limonte-sweetalert2/11.7.12/sweetalert2.min.css" rel="stylesheet">
</head>
<body class="bg-light">

<?php
session_start();
require_once '../includes/dbconnect.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $fname = mysqli_real_escape_string($conn, $_POST['fname']);
    $lname = mysqli_real_escape_string($conn, $_POST['lname']);
    $contact = mysqli_real_escape_string($conn, $_POST['contact']);
    $email = mysqli_real_escape_string($conn, $_POST['email']);
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT);

    // Check if email already exists
    $check_email = "SELECT * FROM users WHERE email = '$email'";
    $result = $conn->query($check_email);
    
    if ($result->num_rows > 0) {
        echo "<script>
            document.addEventListener('DOMContentLoaded', function() {
                Swal.fire({
                    title: 'Email Already Exists!',
                    text: 'This email is already registered. Please use a different email or sign in.',
                    icon: 'warning',
                    confirmButtonText: 'Try Again',
                    confirmButtonColor: '#ffc107'
                });
            });
        </script>";
    } else {
        // Insert new user
        $sql = "INSERT INTO users (first_name, last_name, contact, email, password) 
                VALUES ('$fname', '$lname', '$contact', '$email', '$password')";
        
        if ($conn->query($sql) === TRUE) {
            echo "<script>
                document.addEventListener('DOMContentLoaded', function() {
                    Swal.fire({
                        title: 'Registration Successful!',
                        text: 'Your account has been created successfully. Please login to continue.',
                        icon: 'success',
                        confirmButtonText: 'Go to Login',
                        confirmButtonColor: '#28a745'
                    }).then((result) => {
                        window.location.href='signin.php';
                    });
                });
            </script>";
        } else {
            echo "<script>
                document.addEventListener('DOMContentLoaded', function() {
                    Swal.fire({
                        title: 'Registration Failed!',
                        text: 'Error: " . $conn->error . "',
                        icon: 'error',
                        confirmButtonText: 'Try Again',
                        confirmButtonColor: '#dc3545'
                    });
                });
            </script>";
        }
    }
}
?>

<div class="container-fluid min-vh-100 d-flex align-items-center justify-content-center py-5">
    <div class="row w-100 max-width-1200">
        <div class="col-12">
            <!-- Back to Home Button -->
            <div class="mb-4 text-start">
                <a href="../index.php" class="btn btn-outline-secondary">
                    <i class="fas fa-arrow-left me-2"></i>Back to Home
                </a>
            </div>
            
            <!-- Main Card -->
            <div class="card shadow-lg border-0 rounded-4 overflow-hidden">
                <div class="row g-0">
                    <!-- Info Section -->
                    <div class="col-lg-5 col-md-5 col-12 bg-success bg-gradient">
                        <div class="d-flex flex-column justify-content-center align-items-center h-100 p-5 text-white text-center">
                            <div class="mb-4">
                                <i class="fas fa-user-plus display-1 opacity-75"></i>
                            </div>
                            <h3 class="fw-bold mb-3">Join Us Today!</h3>
                            <p class="lead mb-4 opacity-90">
                                Create your account and become part of our amazing community.
                            </p>
                            <div class="d-flex flex-column gap-2 mb-4">
                                <div class="d-flex align-items-center">
                                    <i class="fas fa-check-circle me-2"></i>
                                    <span>Quick Registration</span>
                                </div>
                                <div class="d-flex align-items-center">
                                    <i class="fas fa-check-circle me-2"></i>
                                    <span>Secure Account</span>
                                </div>
                                <div class="d-flex align-items-center">
                                    <i class="fas fa-check-circle me-2"></i>
                                    <span>Easy Access</span>
                                </div>
                            </div>
                            <div class="border-top pt-4 w-100">
                                <p class="mb-2">Already have an account?</p>
                                <a href="../pages/signin.php" class="btn btn-outline-light btn-lg rounded-pill">
                                    <i class="fas fa-sign-in-alt me-2"></i>Sign In
                                </a>
                            </div>
                        </div>
                    </div>
                    
                    <!-- Form Section -->
                    <div class="col-lg-7 col-md-7 col-12">
                        <div class="card-body p-5">
                            <div class="text-center mb-4">
                                <h2 class="fw-bold text-dark mb-2">
                                    <i class="fas fa-user-plus text-success me-2"></i>Create Account
                                </h2>
                                <p class="text-muted">Fill in your details to get started</p>
                            </div>
                            
                            <form action="signup.php" method="post" class="needs-validation" novalidate>
                                <div class="row">
                                    <div class="col-md-6 mb-3">
                                        <label for="fname" class="form-label fw-semibold">
                                            <i class="fas fa-user text-success me-2"></i>First Name
                                        </label>
                                        <input type="text" 
                                               class="form-control form-control-lg rounded-pill px-4" 
                                               id="fname" 
                                               name="fname" 
                                               placeholder="Enter first name"
                                               required>
                                        <div class="invalid-feedback">
                                            Please provide your first name.
                                        </div>
                                    </div>
                                    
                                    <div class="col-md-6 mb-3">
                                        <label for="lname" class="form-label fw-semibold">
                                            <i class="fas fa-user text-success me-2"></i>Last Name
                                        </label>
                                        <input type="text" 
                                               class="form-control form-control-lg rounded-pill px-4" 
                                               id="lname" 
                                               name="lname" 
                                               placeholder="Enter last name"
                                               required>
                                        <div class="invalid-feedback">
                                            Please provide your last name.
                                        </div>
                                    </div>
                                </div>
                                
                                <div class="mb-3">
                                    <label for="contact" class="form-label fw-semibold">
                                        <i class="fas fa-phone text-success me-2"></i>Contact Number
                                    </label>
                                    <input type="tel" 
                                           class="form-control form-control-lg rounded-pill px-4" 
                                           id="contact" 
                                           name="contact" 
                                           placeholder="Enter your contact number"
                                           pattern="[0-9]{10,15}"
                                           required>
                                    <div class="invalid-feedback">
                                        Please provide a valid contact number.
                                    </div>
                                </div>
                                
                                <div class="mb-3">
                                    <label for="email" class="form-label fw-semibold">
                                        <i class="fas fa-envelope text-success me-2"></i>Email Address
                                    </label>
                                    <input type="email" 
                                           class="form-control form-control-lg rounded-pill px-4" 
                                           id="email" 
                                           name="email" 
                                           placeholder="Enter your email"
                                           required>
                                    <div class="invalid-feedback">
                                        Please provide a valid email address.
                                    </div>
                                </div>
                                
                                <div class="mb-4">
                                    <label for="password" class="form-label fw-semibold">
                                        <i class="fas fa-lock text-success me-2"></i>Password
                                    </label>
                                    <div class="position-relative">
                                        <input type="password" 
                                               class="form-control form-control-lg rounded-pill px-4 pe-5" 
                                               id="password" 
                                               name="password" 
                                               placeholder="Create a strong password"
                                               minlength="6"
                                               required>
                                        <button type="button" 
                                                class="btn btn-link position-absolute end-0 top-50 translate-middle-y pe-3 text-muted"
                                                onclick="togglePassword()">
                                            <i class="fas fa-eye" id="toggleIcon"></i>
                                        </button>
                                    </div>
                                    <div class="invalid-feedback">
                                        Password must be at least 6 characters long.
                                    </div>
                                    <div class="form-text">
                                        <small class="text-muted">
                                            <i class="fas fa-info-circle me-1"></i>
                                            Use at least 6 characters for better security
                                        </small>
                                    </div>
                                </div>
                                
                                <div class="d-grid mb-3">
                                    <button type="submit" class="btn btn-success btn-lg rounded-pill fw-semibold">
                                        <i class="fas fa-user-plus me-2"></i>Create Account
                                    </button>
                                </div>
                                
                                <div class="text-center">
                                    <p class="text-muted mb-0">
                                        By signing up, you agree to our 
                                        <a href="#" class="text-success text-decoration-none">Terms of Service</a>
                                        and 
                                        <a href="#" class="text-success text-decoration-none">Privacy Policy</a>
                                    </p>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Bootstrap JS -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.0/js/bootstrap.bundle.min.js"></script>
<!-- SweetAlert2 JS -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/limonte-sweetalert2/11.7.12/sweetalert2.min.js"></script>

<script>
// Bootstrap form validation
(function() {
    'use strict';
    window.addEventListener('load', function() {
        var forms = document.getElementsByClassName('needs-validation');
        var validation = Array.prototype.filter.call(forms, function(form) {
            form.addEventListener('submit', function(event) {
                if (form.checkValidity() === false) {
                    event.preventDefault();
                    event.stopPropagation();
                }
                form.classList.add('was-validated');
            }, false);
        });
    }, false);
})();

// Toggle password visibility
function togglePassword() {
    const passwordField = document.getElementById('password');
    const toggleIcon = document.getElementById('toggleIcon');
    
    if (passwordField.type === 'password') {
        passwordField.type = 'text';
        toggleIcon.className = 'fas fa-eye-slash';
    } else {
        passwordField.type = 'password';
        toggleIcon.className = 'fas fa-eye';
    }
}

// Add some interactive effects
document.addEventListener('DOMContentLoaded', function() {
    // Add focus effects to form inputs
    const inputs = document.querySelectorAll('.form-control');
    inputs.forEach(input => {
        input.addEventListener('focus', function() {
            this.parentElement.classList.add('focused');
        });
        
        input.addEventListener('blur', function() {
            this.parentElement.classList.remove('focused');
        });
    });
    
    // Phone number formatting
    const contactInput = document.getElementById('contact');
    contactInput.addEventListener('input', function(e) {
        // Remove all non-numeric characters
        let value = e.target.value.replace(/\D/g, '');
        e.target.value = value;
    });
    
    // Real-time password strength indicator
    const passwordInput = document.getElementById('password');
    passwordInput.addEventListener('input', function() {
        const password = this.value;
        const strength = getPasswordStrength(password);
        updatePasswordStrength(strength);
    });
});

function getPasswordStrength(password) {
    let strength = 0;
    if (password.length >= 6) strength++;
    if (password.match(/[a-z]/) && password.match(/[A-Z]/)) strength++;
    if (password.match(/\d/)) strength++;
    if (password.match(/[^a-zA-Z\d]/)) strength++;
    return strength;
}

function updatePasswordStrength(strength) {
    const formText = document.querySelector('#password').parentElement.nextElementSibling.nextElementSibling;
    const colors = ['text-danger', 'text-warning', 'text-info', 'text-success'];
    const texts = ['Weak', 'Fair', 'Good', 'Strong'];
    
    // Remove existing classes
    formText.querySelector('small').className = `text-muted`;
    
    if (strength > 0) {
        formText.querySelector('small').className = colors[strength - 1];
        formText.querySelector('small').innerHTML = `
            <i class="fas fa-shield-alt me-1"></i>
            Password strength: ${texts[strength - 1]}
        `;
    } else {
        formText.querySelector('small').innerHTML = `
            <i class="fas fa-info-circle me-1"></i>
            Use at least 6 characters for better security
        `;
    }
}
</script>

<style>
/* Minimal custom styles to enhance Bootstrap without external CSS */
.max-width-1200 {
    max-width: 1200px;
    margin: 0 auto;
}

.focused {
    transform: translateY(-1px);
    transition: transform 0.2s ease;
}

.card {
    transition: transform 0.3s ease, box-shadow 0.3s ease;
}

.btn {
    transition: all 0.3s ease;
}

.btn:hover {
    transform: translateY(-1px);
}

@media (max-width: 768px) {
    .card-body {
        padding: 2rem !important;
    }
    
    .bg-success.bg-gradient {
        padding: 3rem 2rem !important;
    }
}

@media (max-width: 576px) {
    .card-body {
        padding: 1.5rem !important;
    }
    
    .bg-success.bg-gradient {
        padding: 2rem 1.5rem !important;
    }
    
    .row .col-md-6 {
        margin-bottom: 1rem;
    }
}
</style>
</body>
</html>