<?php
session_start();
require_once '../../includes/dbconnect.php';

// Check if admin is logged in


// Handle status updates and deletions
if(isset($_GET['action']) && isset($_GET['id'])) {
    $id = mysqli_real_escape_string($conn, $_GET['id']);
    $action = $_GET['action'];
    
    if($action === 'toggle_status') {
        $sql = "UPDATE vehicle SET status = CASE WHEN status = 'active' THEN 'inactive' ELSE 'active' END WHERE id = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("i", $id);
        $stmt->execute();
        header("Location: adds.php?msg=status_updated");
        exit();
    } 
    elseif($action === 'delete') {
        // First get the image filename
        $img_sql = "SELECT image FROM vehicle WHERE id = ?";
        $stmt = $conn->prepare($img_sql);
        $stmt->bind_param("i", $id);
        $stmt->execute();
        $result = $stmt->get_result();
        if($row = $result->fetch_assoc()) {
            $image_path = "../../uploads/" . $row['image'];
            if(file_exists($image_path)) {
                unlink($image_path); // Delete the image file
            }
        }
        
        // Then delete the record
        $sql = "DELETE FROM vehicle WHERE id = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("i", $id);
        $stmt->execute();
        header("Location: adds.php?msg=deleted");
        exit();
    }
}

// Fetch all vehicles
$sql = "SELECT * FROM vehicle ORDER BY id DESC";
$result = $conn->query($sql);

// Success message handling
$message = '';
if(isset($_GET['msg'])) {
    switch($_GET['msg']) {
        case 'status_updated':
            $message = 'Vehicle status has been updated successfully.';
            break;
        case 'deleted':
            $message = 'Vehicle has been deleted successfully.';
            break;
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
    <title>Manage Vehicles - ManualLK Admin</title>
    <link href="css/styles.css" rel="stylesheet" />
    <script src="https://use.fontawesome.com/releases/v6.3.0/js/all.js" crossorigin="anonymous"></script>
    <style>
        .vehicle-image {
            width: 100px;
            height: 70px;
            object-fit: cover;
            border-radius: 5px;
        }

        .status-badge {
            padding: 5px 10px;
            border-radius: 15px;
            font-size: 0.85rem;
            font-weight: 600;
        }

        .status-active {
            background-color: #d4edda;
            color: #155724;
        }

        .status-inactive {
            background-color: #f8d7da;
            color: #721c24;
        }
    </style>
</head>

<body>
    <!-- Navigation -->
    <nav class="sb-topnav navbar navbar-expand navbar-dark bg-dark">
        <a class="navbar-brand ps-3" href="index.php">ADMIN PANEL</a>
        <button class="btn btn-link btn-sm order-1 order-lg-0 me-4 me-lg-0" id="sidebarToggle">
            <i class="fas fa-bars"></i>
        </button>
        <ul class="navbar-nav ms-auto me-3 me-lg-4">
            <li class="nav-item dropdown">
                <a class="nav-link dropdown-toggle" id="navbarDropdown" href="#" role="button"
                   data-bs-toggle="dropdown" aria-expanded="false">
                    <i class="fas fa-user fa-fw"></i>
                </a>
                <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="navbarDropdown">
                    <li><a class="dropdown-item" href="../../inc/logout.php">Logout</a></li>
                </ul>
            </li>
        </ul>
    </nav>

    <div id="layoutSidenav">
        <div id="layoutSidenav_nav">
            <nav class="sb-sidenav accordion sb-sidenav-dark" id="sidenavAccordion">
                <div class="sb-sidenav-menu">
                    <div class="nav">
                        <div class="sb-sidenav-menu-heading">Main</div>
                        <a class="nav-link" href="index.php">
                            <div class="sb-nav-link-icon"><i class="fas fa-tachometer-alt"></i></div>
                            Dashboard
                        </a>
                        <div class="sb-sidenav-menu-heading">Interface</div>
                        <a class="nav-link collapsed" href="#" data-bs-toggle="collapse" data-bs-target="#collapseLayouts">
                            <div class="sb-nav-link-icon"><i class="fas fa-columns"></i></div>
                            Manage
                            <div class="sb-sidenav-collapse-arrow"><i class="fas fa-angle-down"></i></div>
                        </a>
                        <div class="collapse" id="collapseLayouts">
                            <nav class="sb-sidenav-menu-nested nav">
                                <a class="nav-link" href="adds.php">Manage Adds</a>
                                <a class="nav-link" href="feedback.php">Manage Feedbacks</a>
                            </nav>
                        </div>

                        <div class="sb-sidenav-menu-heading">User Review</div>
                        <a class="nav-link" href="student_feedback.php">
                            <div class="sb-nav-link-icon"><i class="fas fa-chart-area"></i></div>
                            Students Feedback
                        </a>
                    </div>
                </div>
                <div class="sb-sidenav-footer">
                    <div class="small">Logged in as:</div>
                    Admin
                </div>
            </nav>
        </div>

        <div id="layoutSidenav_content">
            <main>
                <div class="container-fluid px-4">
                    <h1 class="mt-4">Manage Vehicles</h1>
                    <ol class="breadcrumb mb-4">
                        <li class="breadcrumb-item">Dashboard</li>
                        <li class="breadcrumb-item active">Manage Vehicles</li>
                    </ol>

                    <?php if ($message): ?>
                    <div class="alert alert-success alert-dismissible fade show" role="alert">
                        <?php echo htmlspecialchars($message); ?>
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                    <?php endif; ?>

                    <div class="card mb-4">
                        <div class="card-header">
                            <i class="fas fa-car me-1"></i>
                            Vehicle Listings
                        </div>
                        <div class="card-body">
                            <table class="table table-bordered table-hover">
                                <thead>
                                    <tr>
                                        <th>Image</th>
                                        <th>Make & Model</th>
                                        <th>Year</th>
                                        <th>Type</th>
                                        <th>Condition</th>
                                        <th>Price</th>
                                        <th>Location</th>
                                        <th>Status</th>
                                        <th>Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    if ($result && $result->num_rows > 0) {
                                        while($row = $result->fetch_assoc()) {
                                            $statusClass = $row['status'] === 'active' ? 'status-active' : 'status-inactive';
                                            echo "<tr>";
                                            echo "<td><img src='../../uploads/" . htmlspecialchars($row['image']) . "' class='vehicle-image' alt='Vehicle'></td>";
                                            echo "<td>" . htmlspecialchars($row['make'] . " " . $row['model']) . "</td>";
                                            echo "<td>" . htmlspecialchars($row['year']) . "</td>";
                                            echo "<td>" . htmlspecialchars($row['v_type']) . "</td>";
                                            echo "<td>" . htmlspecialchars($row['condition']) . "</td>";
                                            echo "<td>LKR " . number_format($row['price']) . "</td>";
                                            echo "<td>" . htmlspecialchars($row['city']) . "</td>";
                                            echo "<td><span class='status-badge " . $statusClass . "'>" . ucfirst(htmlspecialchars($row['status'])) . "</span></td>";
                                            echo "<td>
                                                    <a href='adds.php?action=toggle_status&id=" . $row['id'] . "' 
                                                       class='btn btn-sm btn-" . ($row['status'] === 'active' ? 'warning' : 'success') . " mb-1'>
                                                       <i class='fas fa-exchange-alt'></i> " . 
                                                       ($row['status'] === 'active' ? 'Deactivate' : 'Activate') . "
                                                    </a>
                                                    <a href='adds.php?action=delete&id=" . $row['id'] . "' 
                                                       class='btn btn-sm btn-danger'
                                                       onclick='return confirm(\"Are you sure you want to delete this vehicle? This will also delete the associated image.\");'>
                                                       <i class='fas fa-trash'></i> Delete
                                                    </a>
                                                  </td>";
                                            echo "</tr>";
                                        }
                                    } else {
                                        echo "<tr><td colspan='9' class='text-center'>No vehicles found</td></tr>";
                                    }
                                    ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </main>

            <footer class="py-4 bg-light mt-auto">
                <div class="container-fluid px-4">
                    <div class="d-flex justify-content-between small">
                        <div class="text-muted">Copyright &copy; Lecture Management System Easy 2024</div>
                    </div>
                </div>
            </footer>
        </div>
    </div>

    <!-- Scripts -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js"></script>
    
</body>

</html>
