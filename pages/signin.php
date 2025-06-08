<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sign IN</title>
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
    $email = mysqli_real_escape_string($conn, $_POST['email']);
    $password = $_POST['password'];
    $sql = "SELECT * FROM users WHERE email = '$email'";
    $result = $conn->query($sql);
    if ($result->num_rows == 1) {
        $user = $result->fetch_assoc();
        if (password_verify($password, $user['password'])) {
            $_SESSION['name'] = $user['first_name'] . ' ' . $user['last_name'];
            $_SESSION['user_id'] = $user['id'];
            $_SESSION['email'] = $user['email'];
            $_SESSION['first_name'] = $user['first_name'];
            $_SESSION['role'] = $user['role'];
           
            echo "<script>
                document.addEventListener('DOMContentLoaded', function() {
                    Swal.fire({
                        title: 'Success!',
                        text: 'Login successful!',
                        icon: 'success',
                        confirmButtonText: 'Continue',
                        confirmButtonColor: '#28a745'
                    }).then((result) => {
                        window.location.href='../index.php';
                    });
                });
            </script>";
        } else {
            echo "<script>
                document.addEventListener('DOMContentLoaded', function() {
                    Swal.fire({
                        title: 'Error!',
                        text: 'Invalid password!',
                        icon: 'error',
                        confirmButtonText: 'Try Again',
                        confirmButtonColor: '#dc3545'
                    });
                });
            </script>";
        }
    } else {
        echo "<script>
            document.addEventListener('DOMContentLoaded', function() {
                Swal.fire({
                    title: 'Error!',
                    text: 'User not found!',
                    icon: 'error',
                    confirmButtonText: 'Try Again',
                    confirmButtonColor: '#dc3545'
                });
            });
        </script>";
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
                    <!-- Form Section -->
                    <div class="col-lg-6 col-md-7 col-12">
                        <div class="card-body p-5">
                            <div class="text-center mb-4">
                                <h2 class="fw-bold text-dark mb-2">
                                    <i class="fas fa-sign-in-alt text-primary me-2"></i>Sign In
                                </h2>
                                <p class="text-muted">Welcome back! Please sign in to your account</p>
                            </div>
                            
                            <form action="signin.php" method="post" class="needs-validation" novalidate>
                                <div class="mb-4">
                                    <label for="email" class="form-label fw-semibold">
                                        <i class="fas fa-envelope text-primary me-2"></i>Email Address
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
                                        <i class="fas fa-lock text-primary me-2"></i>Password
                                    </label>
                                    <div class="position-relative">
                                        <input type="password" 
                                               class="form-control form-control-lg rounded-pill px-4 pe-5" 
                                               id="password" 
                                               name="password" 
                                               placeholder="Enter your password"
                                               required>
                                        <button type="button" 
                                                class="btn btn-link position-absolute end-0 top-50 translate-middle-y pe-3 text-muted"
                                                onclick="togglePassword()">
                                            <i class="fas fa-eye" id="toggleIcon"></i>
                                        </button>
                                    </div>
                                    <div class="invalid-feedback">
                                        Please provide your password.
                                    </div>
                                </div>
                                
                                <div class="d-grid mb-4">
                                    <button type="submit" class="btn btn-primary btn-lg rounded-pill fw-semibold">
                                        <i class="fas fa-sign-in-alt me-2"></i>Sign In
                                    </button>
                                </div>
                                
                                <div class="text-center">
                                    <p class="text-muted mb-0">
                                        Don't have an account? 
                                        <a href="../pages/signup.php" class="text-primary text-decoration-none fw-semibold">
                                            Sign Up Here
                                        </a>
                                    </p>
                                </div>
                            </form>
                        </div>
                    </div>
                    
                    <!-- Info Section -->
                    <div class="col-lg-6 col-md-5 col-12 bg-primary bg-gradient">
                        <div class="d-flex flex-column justify-content-center align-items-center h-100 p-5 text-white text-center">
                            <div class="mb-4">
                                <i class="fas fa-user-circle display-1 opacity-75"></i>
                            </div>
                            <h3 class="fw-bold mb-3">Welcome Back!</h3>
                            <p class="lead mb-4 opacity-90">
                                Sign in to access your account and continue your journey with us.
                            </p>
                            <div class="d-flex flex-column gap-2">
                                <div class="d-flex align-items-center">
                                    <i class="fas fa-check-circle me-2"></i>
                                    <span>Secure Login</span>
                                </div>
                                <div class="d-flex align-items-center">
                                    <i class="fas fa-check-circle me-2"></i>
                                    <span>Fast Access</span>
                                </div>
                                <div class="d-flex align-items-center">
                                    <i class="fas fa-check-circle me-2"></i>
                                    <span>User Friendly</span>
                                </div>
                            </div>
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
});
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
    
    .bg-primary.bg-gradient {
        padding: 3rem 2rem !important;
    }
}

@media (max-width: 576px) {
    .card-body {
        padding: 1.5rem !important;
    }
    
    .bg-primary.bg-gradient {
        padding: 2rem 1.5rem !important;
    }
}
</style>
</body>
</html>