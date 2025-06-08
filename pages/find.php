<?php
session_start();
require_once '../includes/dbconnect.php';

// Initialize the base query
$sql = "SELECT * FROM vehicle WHERE status = 'active'";
$conditions = [];
$params = [];
$param_types = "";

// Handle condition filter
if (isset($_GET['condition']) && !empty($_GET['condition'])) {
    $conditions[] = "`condition` = ?";
    $params[] = $_GET['condition'];
    $param_types .= "s";
}

// Handle price range filter
if (isset($_GET['min_price']) && !empty($_GET['min_price'])) {
    $conditions[] = "price >= ?";
    $params[] = $_GET['min_price'];
    $param_types .= "d";
}

if (isset($_GET['max_price']) && !empty($_GET['max_price'])) {
    $conditions[] = "price <= ?";
    $params[] = $_GET['max_price'];
    $param_types .= "d";
}

// Add conditions to query if any exist
if (!empty($conditions)) {
    $sql .= " AND " . implode(" AND ", $conditions);
}

$sql .= " ORDER BY id DESC";

// Prepare and execute the statement
$stmt = $conn->prepare($sql);
if (!empty($params)) {
    $stmt->bind_param($param_types, ...$params);
}
$stmt->execute();
$result = $stmt->get_result();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Find Your Dream Vehicle | ManualLK</title>
    <link rel="icon" type="image/png" href="../assets/images/logotransp.png">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</head>
<body class="bg-light">
    <?php include '../partials/navbar.php'; ?>

    <!-- Hero Section with Background Image -->
    <div class="position-relative overflow-hidden bg-dark text-white">
        <div class="position-absolute top-0 start-0 w-100 h-100" 
             style="background: linear-gradient(rgba(0,0,0,0.6), rgba(0,0,0,0.4)), url('../assets/images/audi.jpg') center/cover no-repeat; z-index: -1;">
        </div>
        
        <!-- Back to Home Button -->
        <div class="position-absolute top-0 end-0 m-4">
            <a href="../index.php" class="btn btn-outline-light btn-lg rounded-pill shadow-sm">
                <i class="fas fa-arrow-left me-2"></i>
                Back to Home
            </a>
        </div>

        <!-- Hero Content -->
        <div class="container py-5">
            <div class="row justify-content-center text-center py-5 my-5">
                <div class="col-lg-8">
                    <h1 class="display-3 fw-bold mb-4 text-shadow">Find Your Perfect Vehicle</h1>
                    <p class="lead fs-4 mb-0 opacity-75">Explore our extensive collection of quality vehicles</p>
                </div>
            </div>
        </div>
    </div>

    <!-- Search Form Section -->
    <div class="container-fluid px-4" style="margin-top: -100px; position: relative; z-index: 10;">
        <div class="row justify-content-center">
            <div class="col-xl-10 col-lg-11">
                <div class="card shadow-lg border-0 rounded-4">
                    <div class="card-body p-4 p-md-5">
                        <form action="" method="GET">
                            <div class="row g-4">
                                <div class="col-lg-4 col-md-6">
                                    <label class="form-label fw-semibold text-dark">
                                        <i class="fas fa-star text-warning me-2"></i>Condition
                                    </label>
                                    <select name="condition" class="form-select form-select-lg border-2 rounded-3">
                                        <option value="">Any Condition</option>
                                        <option value="brandnew" <?php echo (isset($_GET['condition']) && $_GET['condition'] == 'brandnew') ? 'selected' : ''; ?>>Brand New</option>
                                        <option value="used" <?php echo (isset($_GET['condition']) && $_GET['condition'] == 'used') ? 'selected' : ''; ?>>Used</option>
                                    </select>
                                </div>
                                <div class="col-lg-4 col-md-6">
                                    <label class="form-label fw-semibold text-dark">
                                        <i class="fas fa-money-bill-wave text-success me-2"></i>Minimum Price (LKR)
                                    </label>
                                    <input type="number" name="min_price" class="form-control form-control-lg border-2 rounded-3" 
                                           placeholder="Enter minimum price" value="<?php echo isset($_GET['min_price']) ? htmlspecialchars($_GET['min_price']) : ''; ?>">
                                </div>
                                <div class="col-lg-4 col-md-6">
                                    <label class="form-label fw-semibold text-dark">
                                        <i class="fas fa-money-bill-wave text-success me-2"></i>Maximum Price (LKR)
                                    </label>
                                    <input type="number" name="max_price" class="form-control form-control-lg border-2 rounded-3" 
                                           placeholder="Enter maximum price" value="<?php echo isset($_GET['max_price']) ? htmlspecialchars($_GET['max_price']) : ''; ?>">
                                </div>
                            </div>
                            <div class="row mt-4">
                                <div class="col-12 text-center">
                                    <div class="d-flex flex-column flex-sm-row justify-content-center gap-3">
                                        <button type="submit" class="btn btn-danger btn-lg px-5 py-3 rounded-pill shadow-sm">
                                            <i class="fas fa-search me-2"></i>Find Vehicles
                                        </button>
                                        <a href="find.php" class="btn btn-secondary btn-lg px-5 py-3 rounded-pill shadow-sm">
                                            <i class="fas fa-times me-2"></i>Clear Filters
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Vehicles Section -->
    <section class="py-5 mt-5">
        <div class="container-fluid px-4">
            <!-- Section Header -->
            <div class="text-center mb-5">
                <h2 class="display-4 fw-bold text-dark mb-3">Available Vehicles</h2>
                <p class="lead text-muted fs-5">Browse through our collection of high-quality vehicles</p>
                <div class="mx-auto bg-danger" style="height: 4px; width: 80px; border-radius: 2px;"></div>
            </div>

            <!-- Vehicles Grid -->
            <?php if ($result && $result->num_rows > 0): ?>
                <div class="row row-cols-1 row-cols-md-2 row-cols-lg-3 row-cols-xl-4 g-4">
                    <?php while($vehicle = $result->fetch_assoc()): ?>
                        <div class="col">
                            <div class="card h-100 shadow-sm border-0 rounded-4 overflow-hidden hover-card">
                                <!-- Vehicle Image -->
                                <div class="position-relative overflow-hidden">
                                    <img src="../uploads/<?php echo htmlspecialchars($vehicle['image']); ?>" 
                                         alt="<?php echo htmlspecialchars($vehicle['make'] . ' ' . $vehicle['model']); ?>" 
                                         class="card-img-top" style="height: 250px; object-fit: cover;">
                                    <div class="position-absolute top-0 end-0 m-3">
                                        <span class="badge bg-danger rounded-pill px-3 py-2 fs-6">
                                            <?php echo ucfirst(htmlspecialchars($vehicle['condition'] ?? 'used')); ?>
                                        </span>
                                    </div>
                                </div>

                                <!-- Card Body -->
                                <div class="card-body p-4 d-flex flex-column">
                                    <!-- Vehicle Title -->
                                    <h5 class="card-title fw-bold text-dark mb-3 fs-4">
                                        <?php echo htmlspecialchars($vehicle['make'] . ' ' . $vehicle['model']); ?>
                                    </h5>

                                    <!-- Vehicle Info Grid -->
                                    <div class="row g-3 mb-4">
                                        <div class="col-6">
                                            <div class="d-flex align-items-center text-muted">
                                                <i class="fas fa-calendar-alt text-danger me-2"></i>
                                                <small class="fw-medium"><?php echo htmlspecialchars($vehicle['year']); ?></small>
                                            </div>
                                        </div>
                                        <div class="col-6">
                                            <div class="d-flex align-items-center text-muted">
                                                <i class="fas fa-car text-primary me-2"></i>
                                                <small class="fw-medium"><?php echo htmlspecialchars($vehicle['v_type']); ?></small>
                                            </div>
                                        </div>
                                        <div class="col-6">
                                            <div class="d-flex align-items-center text-muted">
                                                <i class="fas fa-gas-pump text-success me-2"></i>
                                                <small class="fw-medium"><?php echo htmlspecialchars($vehicle['f_type']); ?></small>
                                            </div>
                                        </div>
                                        <div class="col-6">
                                            <div class="d-flex align-items-center text-muted">
                                                <i class="fas fa-map-marker-alt text-warning me-2"></i>
                                                <small class="fw-medium"><?php echo htmlspecialchars($vehicle['city']); ?></small>
                                            </div>
                                        </div>
                                    </div>

                                    <!-- Price -->
                                    <div class="mb-3">
                                        <h4 class="text-danger fw-bold mb-2">
                                            LKR <?php echo ($vehicle['price']); ?>
                                        </h4>
                                        <div class="d-flex align-items-center text-dark">
                                            <i class="fas fa-phone text-info me-2"></i>
                                            <span class="fw-semibold"><?php echo htmlspecialchars($vehicle['phone']); ?></span>
                                        </div>
                                    </div>

                                    <!-- Contact Button -->
                                    <div class="mt-auto">
                                        <button class="btn btn-danger w-100 py-3 rounded-pill fw-semibold shadow-sm contact-seller-btn" 
                                                data-phone="<?php echo htmlspecialchars($vehicle['phone']); ?>"
                                                data-vehicle="<?php echo htmlspecialchars($vehicle['make'] . ' ' . $vehicle['model']); ?>">
                                            <i class="fas fa-phone me-2"></i>Contact Seller
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    <?php endwhile; ?>
                </div>
            <?php else: ?>
                <!-- No Results -->
                <div class="text-center py-5">
                    <div class="mb-4">
                        <i class="fas fa-car-slash display-1 text-muted"></i>
                    </div>
                    <h3 class="text-dark mb-3">No Vehicles Found</h3>
                    <p class="text-muted fs-5 mb-4">Try adjusting your search filters to find more results</p>
                    <a href="find.php" class="btn btn-danger btn-lg rounded-pill px-5">
                        <i class="fas fa-refresh me-2"></i>Reset Search
                    </a>
                </div>
            <?php endif; ?>
        </div>
    </section>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>

    <script>
        // Add hover effects using Bootstrap classes
        document.addEventListener('DOMContentLoaded', function() {
            // Add hover animation to cards
            const cards = document.querySelectorAll('.hover-card');
            cards.forEach(card => {
                card.addEventListener('mouseenter', function() {
                    this.style.transform = 'translateY(-5px)';
                    this.style.transition = 'all 0.3s ease';
                    this.classList.add('shadow-lg');
                });
                
                card.addEventListener('mouseleave', function() {
                    this.style.transform = 'translateY(0)';
                    this.classList.remove('shadow-lg');
                    this.classList.add('shadow-sm');
                });
            });

            // Contact Seller Button with SweetAlert
            const contactButtons = document.querySelectorAll('.contact-seller-btn');
            contactButtons.forEach(button => {
                button.addEventListener('click', function() {
                    const phone = this.getAttribute('data-phone');
                    const vehicle = this.getAttribute('data-vehicle');
                    
                    Swal.fire({
                        title: 'Contact Seller',
                        html: `
                            <div class="text-start">
                                <p class="mb-3"><strong>Vehicle:</strong> ${vehicle}</p>
                                <p class="mb-3"><strong>Phone:</strong> ${phone}</p>
                                <p class="text-muted">Would you like to call the seller now?</p>
                            </div>
                        `,
                        icon: 'question',
                        showCancelButton: true,
                        confirmButtonText: '<i class="fas fa-phone me-2"></i>Call Now',
                        cancelButtonText: 'Cancel',
                        confirmButtonColor: '#dc3545',
                        cancelButtonColor: '#6c757d',
                        customClass: {
                            popup: 'rounded-4',
                            confirmButton: 'rounded-pill px-4',
                            cancelButton: 'rounded-pill px-4'
                        }
                    }).then((result) => {
                        if (result.isConfirmed) {
                            window.location.href = `tel:${phone}`;
                        }
                    });
                });
            });

            // Show success message if filters were applied
            <?php if (!empty($_GET)): ?>
                const filterCount = <?php echo count(array_filter($_GET)); ?>;
                const resultCount = <?php echo $result ? $result->num_rows : 0; ?>;
                
                if (filterCount > 0) {
                    Swal.fire({
                        title: 'Filters Applied!',
                        text: `Found ${resultCount} vehicle(s) matching your criteria`,
                        icon: 'success',
                        timer: 2000,
                        showConfirmButton: false,
                        customClass: {
                            popup: 'rounded-4'
                        }
                    });
                }
            <?php endif; ?>

            // Add text shadow effect
            const textShadowElements = document.querySelectorAll('.text-shadow');
            textShadowElements.forEach(element => {
                element.style.textShadow = '2px 2px 4px rgba(0,0,0,0.5)';
            });
        });
    </script>
</body>
</html>