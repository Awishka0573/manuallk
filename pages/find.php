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
    <link rel="stylesheet" href="../assets/css/find.css">
    <link rel="icon" type="image/png" href="../assets/images/logotransp.png">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;500;600;700&display=swap');
        
        :root {
            --primary-color: #ff3838;
            --primary-dark: #d40000;
            --text-dark: #2d3436;
            --text-light: #636e72;
            --background-light: #f8f9fa;
            --white: #ffffff;
            --shadow-sm: 0 2px 8px rgba(0,0,0,0.1);
            --shadow-md: 0 4px 12px rgba(0,0,0,0.15);
            --transition: all 0.3s ease;
        }

        body {
            font-family: 'Plus Jakarta Sans', sans-serif;
            background-color: var(--background-light);
            color: var(--text-dark);
            line-height: 1.6;
        }

        /* Hero Section */
        .hero-section {
            background: linear-gradient(135deg, rgba(0,0,0,0.8), rgba(0,0,0,0.4)),
                        url('../assets/images/audi.jpg') no-repeat center;
            background-size: cover;
            min-height: 60vh;
            display: flex;
            align-items: center;
            position: relative;
            padding: 120px 0 160px;
        }

        .hero-content {
            color: var(--white);
            text-align: center;
            max-width: 800px;
            margin: 0 auto;
            padding: 0 20px;
        }

        .hero-title {
            font-size: 3.5rem;
            font-weight: 700;
            margin-bottom: 1.5rem;
            line-height: 1.2;
        }

        .hero-subtitle {
            font-size: 1.25rem;
            opacity: 0.9;
            margin-bottom: 2rem;
        }

        /* Search Section */
        .search-section {
            margin-top: -100px;
            padding: 0 20px;
            position: relative;
            z-index: 10;
        }

        .search-container {
            background: var(--white);
            border-radius: 20px;
            padding: 40px;
            box-shadow: var(--shadow-md);
            max-width: 1200px;
            margin: 0 auto;
        }

        .form-group {
            margin-bottom: 1.5rem;
        }

        .form-label {
            font-weight: 600;
            color: var(--text-dark);
            margin-bottom: 0.5rem;
            font-size: 0.95rem;
        }

        .form-control, .form-select {
            padding: 0.75rem 1rem;
            border: 2px solid #e9ecef;
            border-radius: 12px;
            font-size: 1rem;
            transition: var(--transition);
            color: var(--text-dark);
        }

        .form-control:focus, .form-select:focus {
            border-color: var(--primary-color);
            box-shadow: 0 0 0 3px rgba(255, 56, 56, 0.1);
        }

        .search-btn {
            background: var(--primary-color);
            color: var(--white);
            border: none;
            padding: 1rem 2rem;
            font-size: 1.1rem;
            font-weight: 600;
            border-radius: 12px;
            cursor: pointer;
            transition: var(--transition);
            width: 100%;
            max-width: 200px;
        }

        .search-btn:hover {
            background: var(--primary-dark);
            transform: translateY(-2px);
            box-shadow: 0 4px 15px rgba(255, 56, 56, 0.3);
        }

        /* Vehicles Section */
        .vehicles-section {
            padding: 80px 0;
            background: var(--background-light);
        }

        .section-header {
            text-align: center;
            margin-bottom: 50px;
        }

        .section-title {
            font-size: 2.5rem;
            font-weight: 700;
            color: var(--text-dark);
            margin-bottom: 1rem;
        }

        .section-subtitle {
            color: var(--text-light);
            font-size: 1.1rem;
            max-width: 600px;
            margin: 0 auto;
        }

        .vehicles-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(320px, 1fr));
            gap: 30px;
            padding: 0 20px;
            max-width: 1400px;
            margin: 0 auto;
        }

        .vehicle-card {
            background: var(--white);
            border-radius: 20px;
            overflow: hidden;
            box-shadow: var(--shadow-sm);
            transition: var(--transition);
            height: 100%;
            display: flex;
            flex-direction: column;
        }

        .vehicle-card:hover {
            transform: translateY(-5px);
            box-shadow: var(--shadow-md);
        }

        .vehicle-image {
            width: 100%;
            height: 220px;
            object-fit: cover;
        }

        .vehicle-content {
            padding: 25px;
            flex-grow: 1;
            display: flex;
            flex-direction: column;
        }

        .vehicle-title {
            font-size: 1.4rem;
            font-weight: 700;
            margin-bottom: 1rem;
            color: var(--text-dark);
        }

        .vehicle-info {
            display: grid;
            grid-template-columns: repeat(2, 1fr);
            gap: 15px;
            margin-bottom: 1.5rem;
        }

        .info-item {
            display: flex;
            align-items: center;
            gap: 8px;
            color: var(--text-light);
            font-size: 0.95rem;
        }

        .info-item i {
            color: var(--primary-color);
            font-size: 1.1rem;
        }

        .vehicle-price {
            font-size: 1.8rem;
            font-weight: 700;
            color: var(--primary-color);
            margin-top: auto;
            margin-bottom: 1.5rem;
        }

        .contact-btn {
            background: var(--primary-color);
            color: var(--white);
            border: none;
            padding: 1rem;
            border-radius: 12px;
            font-weight: 600;
            font-size: 1.1rem;
            cursor: pointer;
            transition: var(--transition);
            width: 100%;
            text-align: center;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 10px;
        }

        .contact-btn:hover {
            background: var(--primary-dark);
        }

        .no-results {
            text-align: center;
            padding: 60px 20px;
            color: var(--text-light);
        }

        .no-results i {
            font-size: 4rem;
            color: var(--primary-color);
            margin-bottom: 1.5rem;
        }

        .no-results h3 {
            font-size: 1.8rem;
            color: var(--text-dark);
            margin-bottom: 1rem;
        }

        .home-btn {
            position: absolute;
            top: 30px;
            right: 30px;
            padding: 0.75rem 1.5rem;
            background: rgba(255, 255, 255, 0.2);
            color: var(--white);
            border: 2px solid rgba(255, 255, 255, 0.3);
            border-radius: 12px;
            font-weight: 600;
            backdrop-filter: blur(10px);
            transition: var(--transition);
            text-decoration: none;
            display: flex;
            align-items: center;
            gap: 8px;
        }

        .home-btn:hover {
            background: var(--white);
            color: var(--primary-color);
            border-color: var(--white);
        }

        @media (max-width: 992px) {
            .hero-title {
                font-size: 2.8rem;
            }
            
            .section-title {
                font-size: 2rem;
            }

            .vehicles-grid {
                grid-template-columns: repeat(auto-fill, minmax(280px, 1fr));
            }
        }

        @media (max-width: 768px) {
            .hero-section {
                padding: 100px 0 140px;
            }

            .hero-title {
                font-size: 2.2rem;
            }

            .search-container {
                padding: 25px;
            }

            .vehicles-section {
                padding: 60px 0;
            }

            .section-title {
                font-size: 1.8rem;
            }

            .vehicle-card {
                max-width: 400px;
                margin: 0 auto;
            }
        }

        @media (max-width: 576px) {
            .hero-title {
                font-size: 1.8rem;
            }

            .hero-subtitle {
                font-size: 1rem;
            }

            .home-btn {
                top: 20px;
                right: 20px;
                padding: 0.6rem 1rem;
                font-size: 0.9rem;
            }

            .search-container {
                padding: 20px;
                border-radius: 15px;
            }

            .vehicle-content {
                padding: 20px;
            }

            .vehicle-title {
                font-size: 1.2rem;
            }

            .vehicle-price {
                font-size: 1.5rem;
            }
        }

        .clear-btn {
            background: #6c757d;
            color: var(--white);
            border: none;
            padding: 1rem 2rem;
            font-size: 1.1rem;
            font-weight: 600;
            border-radius: 12px;
            cursor: pointer;
            transition: var(--transition);
            width: 100%;
            max-width: 200px;
            text-decoration: none;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            gap: 10px;
        }

        .clear-btn:hover {
            background: #5a6268;
            transform: translateY(-2px);
            box-shadow: 0 4px 15px rgba(108, 117, 125, 0.3);
            color: var(--white);
            text-decoration: none;
        }
    </style>
</head>
<body>

    <?php include '../partials/navbar.php'; ?>
    <!-- Hero Section -->
    <section class="hero-section">
        <a href="../index.php" class="home-btn">
            <i class="fas fa-arrow-left"></i>
            Back to Home
        </a>
        <div class="hero-content">
            <h1 class="hero-title">Find Your Perfect Vehicle</h1>
            <p class="hero-subtitle">Explore our extensive collection of quality vehicles</p>
        </div>
    </section>

    <!-- Search Section -->
    <section class="search-section">
        <div class="search-container">
            <form action="" method="GET">
                <div class="row g-4">
                    <div class="col-lg-4 col-md-6">
                        <div class="form-group">
                            <label class="form-label">Condition</label>
                            <select name="condition" class="form-select">
                                <option value="">Any Condition</option>
                                <option value="brandnew">Brand New</option>
                                <option value="used">Used</option>
                            </select>
                        </div>
                    </div>
                    <div class="col-lg-4 col-md-6">
                        <div class="form-group">
                            <label class="form-label">Minimum Price (LKR)</label>
                            <input type="number" name="min_price" class="form-control" placeholder="Enter minimum price">
                        </div>
                    </div>
                    <div class="col-lg-4 col-md-6">
                        <div class="form-group">
                            <label class="form-label">Maximum Price (LKR)</label>
                            <input type="number" name="max_price" class="form-control" placeholder="Enter maximum price">
                        </div>
                    </div>
                    <div class="col-12 text-center">
                        <div class="d-flex justify-content-center gap-3">
                            <button type="submit" class="search-btn">
                                <i class="fas fa-search"></i>
                                Find Vehicles
                            </button>
                            <a href="find.php" class="clear-btn">
                                <i class="fas fa-times"></i>
                                Clear Filters
                            </a>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </section>

    <!-- Vehicles Section -->
    <section class="vehicles-section">
        <div class="section-header">
            <h2 class="section-title">Available Vehicles</h2>
            <p class="section-subtitle">Browse through our collection of high-quality vehicles</p>
        </div>

        <div class="vehicles-grid">
            <?php if ($result && $result->num_rows > 0): ?>
                <?php while($vehicle = $result->fetch_assoc()): ?>
                    <div class="vehicle-card">
                        <img src="../uploads/<?php echo htmlspecialchars($vehicle['image']); ?>" 
                             alt="<?php echo htmlspecialchars($vehicle['make'] . ' ' . $vehicle['model']); ?>" 
                             class="vehicle-image">
                        <div class="vehicle-content">
                            <h3 class="vehicle-title">
                                <?php echo htmlspecialchars($vehicle['make'] . ' ' . $vehicle['model']); ?>
                            </h3>
                            <div class="vehicle-info">
                                <div class="info-item">
                                    <i class="fas fa-calendar-alt"></i>
                                    <span><?php echo htmlspecialchars($vehicle['year']); ?></span>
                                </div>
                                <div class="info-item">
                                    <i class="fas fa-car"></i>
                                    <span><?php echo htmlspecialchars($vehicle['v_type']); ?></span>
                                </div>
                                <div class="info-item">
                                    <i class="fas fa-gas-pump"></i>
                                    <span><?php echo htmlspecialchars($vehicle['f_type']); ?></span>
                                </div>
                                <div class="info-item">
                                    <i class="fas fa-map-marker-alt"></i>
                                    <span><?php echo htmlspecialchars($vehicle['city']); ?></span>
                                </div>
                            </div>
                            <div class="vehicle-price">
                                LKR <?php echo number_format($vehicle['price']); ?>
                            </div>
                            <div class="vehicle-price" style="color: #2d3436 ! important; font-size:22px;">
                               phone - <?php echo number_format($vehicle['phone']); ?>
                            </div>
                            <button class="contact-btn" onclick="window.location.href='tel:<?php echo htmlspecialchars($vehicle['phone']); ?>'">
                                <i class="fas fa-phone"></i>
                                Contact Seller
                            </button>
                        </div>
                    </div>
                <?php endwhile; ?>
            <?php else: ?>
                <div class="no-results">
                    <i class="fas fa-car-slash"></i>
                    <h3>No Vehicles Found</h3>
                    <p>Try adjusting your search filters to find more results</p>
                </div>
            <?php endif; ?>
        </div>
    </section>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>