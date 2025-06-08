<?php
require_once '../includes/dbconnect.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $make = $_POST['make'];
    $model = $_POST['model'];
    $year = $_POST['year'];
    $v_type = $_POST['type'];
    $condition = $_POST['condition'];
    $f_type = $_POST['fuel'];
    $city = $_POST['city'];
    $description = $_POST['description'];
    $price = $_POST['price'];
    $phone = $_POST['phone'];
    
    // Handle file upload
    $target_dir = "../uploads/";
    $imageFileType = strtolower(pathinfo($_FILES["vehicle_image"]["name"], PATHINFO_EXTENSION));
    $new_filename = uniqid() . '.' . $imageFileType; // Generate unique filename
    $target_file = $target_dir . $new_filename;
    
    // Check if image file is actual image
    if(isset($_FILES["vehicle_image"])) {
        $check = getimagesize($_FILES["vehicle_image"]["tmp_name"]);
        if($check !== false) {
            // Allow certain file formats
            if($imageFileType == "jpg" || $imageFileType == "png" || $imageFileType == "jpeg") {
                if (move_uploaded_file($_FILES["vehicle_image"]["tmp_name"], $target_file)) {
                    // File uploaded successfully, now insert into database
                    $sql = "INSERT INTO vehicle (make, model, year, v_type, `condition`, f_type, city, description, price, image, phone) 
                            VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
                    
                    $stmt = $conn->prepare($sql);
                    $stmt->bind_param("sssssssssss", $make, $model, $year, $v_type, $condition, $f_type, $city, $description, $price, $new_filename, $phone);
                    
                    if ($stmt->execute()) {
                        echo "<script>
                            document.addEventListener('DOMContentLoaded', function() {
                                Swal.fire({
                                    title: 'Success!',
                                    text: 'Vehicle added successfully!',
                                    icon: 'success',
                                    confirmButtonText: 'Go to Home',
                                    confirmButtonColor: '#007bff',
                                    customClass: {
                                        popup: 'rounded-4',
                                        confirmButton: 'rounded-pill px-4'
                                    }
                                }).then((result) => {
                                    if (result.isConfirmed) {
                                        window.location.href = 'find.php';
                                    }
                                });
                            });
                        </script>";
                    } else {
                        echo "<script>
                            document.addEventListener('DOMContentLoaded', function() {
                                Swal.fire({
                                    title: 'Error!',
                                    text: 'Error: " . addslashes($stmt->error) . "',
                                    icon: 'error',
                                    confirmButtonColor: '#dc3545',
                                    customClass: {
                                        popup: 'rounded-4',
                                        confirmButton: 'rounded-pill px-4'
                                    }
                                });
                            });
                        </script>";
                    }
                    $stmt->close();
                } else {
                    echo "<script>
                        document.addEventListener('DOMContentLoaded', function() {
                            Swal.fire({
                                title: 'Upload Error!',
                                text: 'Sorry, there was an error uploading your file.',
                                icon: 'error',
                                confirmButtonColor: '#dc3545',
                                customClass: {
                                    popup: 'rounded-4',
                                    confirmButton: 'rounded-pill px-4'
                                }
                            });
                        });
                    </script>";
                }
            } else {
                echo "<script>
                    document.addEventListener('DOMContentLoaded', function() {
                        Swal.fire({
                            title: 'Invalid File!',
                            text: 'Sorry, only JPG, JPEG & PNG files are allowed.',
                            icon: 'warning',
                            confirmButtonColor: '#ffc107',
                            customClass: {
                                popup: 'rounded-4',
                                confirmButton: 'rounded-pill px-4'
                            }
                        });
                    });
                </script>";
            }
        } else {
            echo "<script>
                document.addEventListener('DOMContentLoaded', function() {
                    Swal.fire({
                        title: 'Invalid File!',
                        text: 'File is not an image.',
                        icon: 'warning',
                        confirmButtonColor: '#ffc107',
                        customClass: {
                            popup: 'rounded-4',
                            confirmButton: 'rounded-pill px-4'
                        }
                    });
                });
            </script>";
        }
    }
    $conn->close();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sell Vehicle | ManualLK</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <link rel="icon" type="image/png" href="../assets/images/logotransp.png">
    <style>
        .hover-lift {
            transition: transform 0.3s ease, box-shadow 0.3s ease;
        }
        .hover-lift:hover {
            transform: translateY(-5px);
            box-shadow: 0 10px 25px rgba(0,0,0,0.15) !important;
        }
        .bg-gradient-primary {
            background: linear-gradient(135deg, #007bff 0%, #0056b3 100%) !important;
        }
        .form-control:focus, .form-select:focus {
            border-color: #007bff;
            box-shadow: 0 0 0 0.2rem rgba(0, 123, 255, 0.25);
        }
        .btn-primary {
            background: linear-gradient(135deg, #007bff 0%, #0056b3 100%);
            border: none;
        }
        .btn-primary:hover {
            background: linear-gradient(135deg, #0056b3 0%, #004085 100%);
            transform: translateY(-2px);
        }
        .backdrop-blur {
            backdrop-filter: blur(10px);
        }
    </style>
</head>
<body class="bg-light">
    <!-- Navigation -->
    <nav class="navbar navbar-expand-lg navbar-dark bg-primary shadow-sm sticky-top">
        <div class="container">
            <!-- Logo -->
            <a class="navbar-brand d-flex align-items-center fw-bold fs-4" href="../index.php">
                <img src="../assets/images/logotransp.png" alt="Logo" width="40" height="40" class="me-2">
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
                        <a class="nav-link" href="../index.php">
                            <i class="fas fa-home me-1"></i>Home
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="find.php">
                            <i class="fas fa-search me-1"></i>Find
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link active" href="#">
                            <i class="fas fa-plus me-1"></i>Sell
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="aboutus.php">
                            <i class="fas fa-info-circle me-1"></i>About
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link btn btn-outline-light ms-2 px-3" href="start.php">
                            <i class="fas fa-arrow-left me-1"></i>Back
                        </a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    <!-- Hero Section -->
    <section class="bg-gradient-primary text-white py-5">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-lg-8 mx-auto text-center">
                    <div class="card bg-white bg-opacity-10 backdrop-blur border-0 shadow-lg p-4 rounded-4">
                        <h1 class="display-4 fw-bold mb-3">
                            <i class="fas fa-car me-3"></i>
                            Sell Your Vehicle
                        </h1>
                        <p class="lead fs-5 mb-0 opacity-90">
                            List your vehicle and reach thousands of potential buyers across Sri Lanka
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Form Section -->
    <section class="py-5">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-xl-10 col-lg-11">
                    <!-- Main Form Card -->
                    <div class="card border-0 shadow-lg rounded-4 overflow-hidden hover-lift">
                        <div class="card-header bg-primary text-white text-center py-4 border-0">
                            <h3 class="mb-0 fw-bold">
                                <i class="fas fa-clipboard-list me-2"></i>
                                Vehicle Information
                            </h3>
                            <p class="mb-0 mt-2 opacity-75">Fill in the details below to list your vehicle</p>
                        </div>
                        
                        <div class="card-body p-4 p-md-5">
                            <form action="" method="post" enctype="multipart/form-data" id="vehicleForm">
                                <div class="row g-4">
                                    <!-- Vehicle Make -->
                                    <div class="col-md-6">
                                        <div class="form-floating">
                                            <input type="text" class="form-control form-control-lg border-2 rounded-3" 
                                                   name="make" id="make" required placeholder="Vehicle Make">
                                            <label for="make">
                                                <i class="fas fa-car text-primary me-2"></i>Vehicle Make
                                            </label>
                                        </div>
                                    </div>

                                    <!-- Model -->
                                    <div class="col-md-6">
                                        <div class="form-floating">
                                            <input type="text" class="form-control form-control-lg border-2 rounded-3" 
                                                   name="model" id="model" required placeholder="Model">
                                            <label for="model">
                                                <i class="fas fa-tag text-success me-2"></i>Model
                                            </label>
                                        </div>
                                    </div>

                                    <!-- Manufacturing Year -->
                                    <div class="col-md-6">
                                        <div class="form-floating">
                                            <input type="text" class="form-control form-control-lg border-2 rounded-3" 
                                                   name="year" id="year" required placeholder="Manufacturing Year">
                                            <label for="year">
                                                <i class="fas fa-calendar-alt text-info me-2"></i>Manufacturing Year
                                            </label>
                                        </div>
                                    </div>

                                    <!-- Vehicle Type -->
                                    <div class="col-md-6">
                                        <div class="form-floating">
                                            <select class="form-select form-select-lg border-2 rounded-3" 
                                                    name="type" id="type" required>
                                                <option value="">Select Vehicle Type</option>
                                                <option value="motorbike">Motor Bike</option>
                                                <option value="car">Car</option>
                                                <option value="van">Van</option>
                                                <option value="jeep">Jeep</option>
                                                <option value="bus">Bus</option>
                                                <option value="lorry">Lorry</option>
                                                <option value="wheel">Threewheel</option>
                                            </select>
                                            <label for="type">
                                                <i class="fas fa-list text-warning me-2"></i>Vehicle Type
                                            </label>
                                        </div>
                                    </div>

                                    <!-- Vehicle Condition -->
                                    <div class="col-md-6">
                                        <div class="form-floating">
                                            <select class="form-select form-select-lg border-2 rounded-3" 
                                                    name="condition" id="condition" required>
                                                <option value="">Select Condition</option>
                                                <option value="brandnew">Brand New</option>
                                                <option value="used">Used</option>
                                            </select>
                                            <label for="condition">
                                                <i class="fas fa-star text-warning me-2"></i>Vehicle Condition
                                            </label>
                                        </div>
                                    </div>

                                    <!-- Fuel Type -->
                                    <div class="col-md-6">
                                        <div class="form-floating">
                                            <select class="form-select form-select-lg border-2 rounded-3" 
                                                    name="fuel" id="fuel" required>
                                                <option value="">Select Fuel Type</option>
                                                <option value="petrol">Petrol</option>
                                                <option value="diesel">Diesel</option>
                                                <option value="electric">Electric</option>
                                            </select>
                                            <label for="fuel">
                                                <i class="fas fa-gas-pump text-success me-2"></i>Fuel Type
                                            </label>
                                        </div>
                                    </div>

                                    <!-- City -->
                                    <div class="col-md-6">
                                        <div class="form-floating">
                                            <input type="text" class="form-control form-control-lg border-2 rounded-3" 
                                                   name="city" id="city" required placeholder="Your City">
                                            <label for="city">
                                                <i class="fas fa-map-marker-alt text-danger me-2"></i>City
                                            </label>
                                        </div>
                                    </div>

                                    <!-- Contact Number -->
                                    <div class="col-md-6">
                                        <div class="form-floating">
                                            <input type="tel" class="form-control form-control-lg border-2 rounded-3" 
                                                   name="phone" id="phone" pattern="[0-9]{10}" 
                                                   title="Please enter a valid 10-digit phone number" 
                                                   required placeholder="Your Phone Number">
                                            <label for="phone">
                                                <i class="fas fa-phone text-info me-2"></i>Contact Number
                                            </label>
                                        </div>
                                    </div>

                                    <!-- Price -->
                                    <div class="col-md-6">
                                        <div class="form-floating">
                                            <input type="text" class="form-control form-control-lg border-2 rounded-3" 
                                                   name="price" id="price" required placeholder="Vehicle Price">
                                            <label for="price">
                                                <i class="fas fa-money-bill-wave text-success me-2"></i>Price (LKR)
                                            </label>
                                        </div>
                                    </div>

                                    <!-- Vehicle Image -->
                                    <div class="col-12">
                                        <div class="card border-2 border-primary rounded-3 p-4">
                                            <h5 class="card-title text-primary fw-bold mb-3">
                                                <i class="fas fa-camera me-2"></i>Vehicle Image
                                            </h5>
                                            <div class="input-group input-group-lg">
                                                <span class="input-group-text bg-primary text-white border-2 rounded-start-3">
                                                    <i class="fas fa-upload"></i>
                                                </span>
                                                <input type="file" class="form-control form-control-lg border-2 rounded-end-3" 
                                                       name="vehicle_image" id="vehicle_image" accept="image/*" required>
                                            </div>
                                            <div class="form-text text-muted mt-2">
                                                <i class="fas fa-info-circle me-1"></i>
                                                Accepted formats: JPG, JPEG, PNG (Max size: 5MB)
                                            </div>
                                        </div>
                                    </div>

                                    <!-- Vehicle Description -->
                                    <div class="col-12">
                                        <div class="form-floating">
                                            <textarea class="form-control border-2 rounded-3" 
                                                      name="description" id="description" 
                                                      style="height: 150px;" required 
                                                      placeholder="Provide detailed information about your vehicle..."></textarea>
                                            <label for="description">
                                                <i class="fas fa-file-alt text-primary me-2"></i>Vehicle Description
                                            </label>
                                        </div>
                                    </div>

                                    <!-- Submit Button -->
                                    <div class="col-12 text-center mt-5">
                                        <button type="submit" class="btn btn-primary btn-lg px-5 py-3 rounded-pill shadow-lg fw-bold hover-lift">
                                            <i class="fas fa-plus-circle me-2"></i>
                                            List Your Vehicle
                                        </button>
                                        <p class="text-muted mt-3 mb-0">
                                            <i class="fas fa-shield-alt text-success me-1"></i>
                                            Your information is secure and protected
                                        </p>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Features Section -->
    <section class="py-5 bg-white">
        <div class="container">
            <div class="row g-4">
                <div class="col-md-4">
                    <div class="card border-0 shadow-sm rounded-4 h-100 text-center p-4 hover-lift">
                        <div class="card-body">
                            <div class="bg-primary text-white rounded-circle d-inline-flex align-items-center justify-content-center mb-3" style="width: 60px; height: 60px;">
                                <i class="fas fa-users fa-2x"></i>
                            </div>
                            <h5 class="fw-bold text-primary mb-3">Wide Reach</h5>
                            <p class="text-muted">Connect with thousands of potential buyers across Sri Lanka</p>
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="card border-0 shadow-sm rounded-4 h-100 text-center p-4 hover-lift">
                        <div class="card-body">
                            <div class="bg-success text-white rounded-circle d-inline-flex align-items-center justify-content-center mb-3" style="width: 60px; height: 60px;">
                                <i class="fas fa-shield-alt fa-2x"></i>
                            </div>
                            <h5 class="fw-bold text-success mb-3">Secure Platform</h5>
                            <p class="text-muted">Your data and listings are protected with advanced security</p>
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="card border-0 shadow-sm rounded-4 h-100 text-center p-4 hover-lift">
                        <div class="card-body">
                            <div class="bg-warning text-dark rounded-circle d-inline-flex align-items-center justify-content-center mb-3" style="width: 60px; height: 60px;">
                                <i class="fas fa-clock fa-2x"></i>
                            </div>
                            <h5 class="fw-bold text-warning mb-3">Quick Process</h5>
                            <p class="text-muted">List your vehicle in minutes with our simple form</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Form validation and enhancement
            const form = document.getElementById('vehicleForm');
            const fileInput = document.getElementById('vehicle_image');
            
            // File input validation
            fileInput.addEventListener('change', function() {
                const file = this.files[0];
                if (file) {
                    const fileSize = file.size / 1024 / 1024; // Size in MB
                    const allowedTypes = ['image/jpeg', 'image/jpg', 'image/png'];
                    
                    if (!allowedTypes.includes(file.type)) {
                        Swal.fire({
                            title: 'Invalid File Type!',
                            text: 'Please select a valid image file (JPG, JPEG, PNG)',
                            icon: 'warning',
                            confirmButtonColor: '#ffc107',
                            customClass: {
                                popup: 'rounded-4',
                                confirmButton: 'rounded-pill px-4'
                            }
                        });
                        this.value = '';
                        return;
                    }
                    
                    if (fileSize > 5) {
                        Swal.fire({
                            title: 'File Too Large!',
                            text: 'Please select an image smaller than 5MB',
                            icon: 'warning',
                            confirmButtonColor: '#ffc107',
                            customClass: {
                                popup: 'rounded-4',
                                confirmButton: 'rounded-pill px-4'
                            }
                        });
                        this.value = '';
                        return;
                    }
                    
                    // Show success message for valid file
                    const fileName = file.name;
                    Swal.fire({
                        title: 'File Selected!',
                        text: `Selected: ${fileName}`,
                        icon: 'success',
                        timer: 2000,
                        showConfirmButton: false,
                        customClass: {
                            popup: 'rounded-4'
                        }
                    });
                }
            });

            // Form submission with loading
            form.addEventListener('submit', function(e) {
                const submitBtn = this.querySelector('button[type="submit"]');
                const originalText = submitBtn.innerHTML;
                
                // Show loading state
                submitBtn.innerHTML = '<i class="fas fa-spinner fa-spin me-2"></i>Uploading...';
                submitBtn.disabled = true;
                
                // Show loading alert
                Swal.fire({
                    title: 'Uploading Vehicle...',
                    text: 'Please wait while we process your listing',
                    icon: 'info',
                    allowOutsideClick: false,
                    showConfirmButton: false,
                    customClass: {
                        popup: 'rounded-4'
                    },
                    didOpen: () => {
                        Swal.showLoading();
                    }
                });
                
                // Reset button after a delay (in case of errors)
                setTimeout(() => {
                    submitBtn.innerHTML = originalText;
                    submitBtn.disabled = false;
                }, 10000);
            });

            // Phone number formatting
            const phoneInput = document.getElementById('phone');
            phoneInput.addEventListener('input', function() {
                // Remove non-digits
                let value = this.value.replace(/\D/g, '');
                // Limit to 10 digits
                if (value.length > 10) {
                    value = value.slice(0, 10);
                }
                this.value = value;
            });

            // Price formatting
            const priceInput = document.getElementById('price');
            priceInput.addEventListener('input', function() {
                // Remove non-digits
                let value = this.value.replace(/\D/g, '');
                // Add commas for thousands
                if (value) {
                    value = parseInt(value).toLocaleString();
                }
                this.value = value;
            });

            // Add smooth scrolling
            document.documentElement.style.scrollBehavior = "smooth";
        });
    </script>
</body>
</html>