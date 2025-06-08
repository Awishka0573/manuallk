<?php
session_start();
require_once '../../includes/dbconnect.php';

// Check if admin is logged in


// Update status if requested
if (isset($_GET['action']) && isset($_GET['id'])) {
    $id = mysqli_real_escape_string($conn, $_GET['id']);
    $action = $_GET['action'];

    if ($action === 'toggle_status') {
        $sql = "UPDATE feedback SET status = CASE WHEN status = 'active' THEN 'inactive' ELSE 'active' END WHERE feedback_id = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("i", $id);
        $stmt->execute();
        header("Location: feedback.php?msg=status_updated");
        exit();
    } elseif ($action === 'delete') {
        $sql = "DELETE FROM feedback WHERE feedback_id = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("i", $id);
        $stmt->execute();
        header("Location: feedback.php?msg=deleted");
        exit();
    }
}

// Fetch all feedback with user information
$sql = "SELECT f.*, u.first_name, u.last_name 
        FROM feedback f 
        LEFT JOIN users u ON f.user_id = u.id 
        ORDER BY feedback_id DESC";
$result = $conn->query($sql);

// Count total feedback
$feedbackCount = $conn->query("SELECT COUNT(*) as count FROM feedback")->fetch_assoc()['count'];

// Success message handling
$message = '';
if (isset($_GET['msg'])) {
    switch ($_GET['msg']) {
        case 'status_updated':
            $message = 'Feedback status has been updated successfully.';
            break;
        case 'deleted':
            $message = 'Feedback has been deleted successfully.';
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
    <meta name="description" content="" />
    <meta name="author" content="" />
    <title>Feedback Management - ManualLK</title>
    <link rel="icon" type="image/png" href="assets\images\logotransp.png">

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://use.fontawesome.com/releases/v6.3.0/js/all.js" crossorigin="anonymous"></script>
    
    <style>
        :root {
            --primary-color: #667eea;
            --secondary-color: #764ba2;
            --success-color: #48bb78;
            --warning-color: #ed8936;
            --danger-color: #f56565;
            --info-color: #4299e1;
            --dark-color: #1a202c;
            --light-color: #f7fafc;
            --sidebar-width: 280px;
        }

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            min-height: 100vh;
            overflow-x: hidden;
        }

        /* Animated Background */
        body::before {
            content: '';
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: url('data:image/svg+xml,<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 100 100"><defs><pattern id="grain" width="100" height="100" patternUnits="userSpaceOnUse"><circle cx="20" cy="20" r="1" fill="rgba(255,255,255,0.1)"/><circle cx="80" cy="40" r="1" fill="rgba(255,255,255,0.1)"/><circle cx="40" cy="80" r="1" fill="rgba(255,255,255,0.1)"/></pattern></defs><rect width="100" height="100" fill="url(%23grain)"/></svg>');
            opacity: 0.3;
            z-index: -1;
            animation: float 20s ease-in-out infinite;
        }

        @keyframes float {
            0%, 100% { transform: translateY(0px) rotate(0deg); }
            50% { transform: translateY(-20px) rotate(2deg); }
        }

        /* Top Navigation */
        .top-nav {
            background: rgba(255, 255, 255, 0.95);
            backdrop-filter: blur(20px);
            border-bottom: 1px solid rgba(255, 255, 255, 0.2);
            padding: 1rem 2rem;
            position: fixed;
            top: 0;
            left: 0;
            right: 0;
            z-index: 1000;
            box-shadow: 0 8px 32px rgba(0, 0, 0, 0.1);
        }

        .nav-brand {
            font-size: 1.5rem;
            font-weight: 700;
            background: linear-gradient(135deg, var(--primary-color), var(--secondary-color));
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
            text-decoration: none;
        }

        .nav-user {
            display: flex;
            align-items: center;
            gap: 1rem;
        }

        .nav-avatar {
            width: 40px;
            height: 40px;
            border-radius: 50%;
            background: linear-gradient(135deg, var(--primary-color), var(--secondary-color));
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.3s ease;
        }

        .nav-avatar:hover {
            transform: scale(1.1);
            box-shadow: 0 8px 25px rgba(102, 126, 234, 0.4);
        }

        /* Sidebar */
        .sidebar {
            position: fixed;
            top: 80px;
            left: 0;
            width: var(--sidebar-width);
            height: calc(100vh - 80px);
            background: rgba(255, 255, 255, 0.95);
            backdrop-filter: blur(20px);
            border-right: 1px solid rgba(255, 255, 255, 0.2);
            padding: 2rem 0;
            z-index: 999;
            box-shadow: 8px 0 32px rgba(0, 0, 0, 0.1);
        }

        .sidebar-menu {
            list-style: none;
            padding: 0;
        }

        .sidebar-item {
            margin-bottom: 0.5rem;
        }

        .sidebar-link {
            display: flex;
            align-items: center;
            padding: 1rem 2rem;
            color: #4a5568;
            text-decoration: none;
            transition: all 0.3s ease;
            position: relative;
        }

        .sidebar-link:hover {
            background: linear-gradient(135deg, rgba(102, 126, 234, 0.1), rgba(118, 75, 162, 0.1));
            color: var(--primary-color);
            transform: translateX(5px);
        }

        .sidebar-link.active {
            background: linear-gradient(135deg, var(--primary-color), var(--secondary-color));
            color: white;
        }

        .sidebar-link.active::before {
            content: '';
            position: absolute;
            left: 0;
            top: 0;
            height: 100%;
            width: 4px;
            background: var(--warning-color);
        }

        .sidebar-icon {
            margin-right: 1rem;
            font-size: 1.2rem;
        }

        /* Main Content */
        .main-content {
            margin-left: var(--sidebar-width);
            margin-top: 80px;
            padding: 2rem;
            min-height: calc(100vh - 80px);
        }

        .page-header {
            margin-bottom: 2rem;
        }

        .page-title {
            font-size: 2.5rem;
            font-weight: 700;
            color: white;
            text-shadow: 2px 2px 4px rgba(0, 0, 0, 0.3);
            margin-bottom: 0.5rem;
        }

        .breadcrumb {
            background: rgba(255, 255, 255, 0.2);
            border-radius: 25px;
            padding: 0.5rem 1.5rem;
            backdrop-filter: blur(10px);
        }

        .breadcrumb-item {
            color: rgba(255, 255, 255, 0.8);
        }

        .breadcrumb-item.active {
            color: white;
            font-weight: 600;
        }

        /* Stats Card */
        .stat-card {
            background: rgba(255, 255, 255, 0.95);
            backdrop-filter: blur(20px);
            border-radius: 20px;
            padding: 2rem;
            box-shadow: 0 20px 40px rgba(0, 0, 0, 0.1);
            border: 1px solid rgba(255, 255, 255, 0.3);
            transition: all 0.3s ease;
            position: relative;
            overflow: hidden;
            margin-bottom: 2rem;
        }

        .stat-card::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            height: 4px;
            background: linear-gradient(90deg, var(--primary-color), var(--secondary-color));
        }

        .stat-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 30px 60px rgba(0, 0, 0, 0.2);
        }

        .stat-icon {
            width: 80px;
            height: 80px;
            border-radius: 20px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 2rem;
            margin-bottom: 1.5rem;
            position: relative;
            background: linear-gradient(135deg, #d299c2, #fef9d7);
            color: #3182ce;
            float: left;
            margin-right: 1.5rem;
        }

        .stat-number {
            font-size: 3rem;
            font-weight: 800;
            color: #2d3748;
            margin-bottom: 0.5rem;
            background: linear-gradient(135deg, var(--primary-color), var(--secondary-color));
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
        }

        .stat-label {
            font-size: 1.1rem;
            color: #718096;
            font-weight: 600;
        }

        /* Alert Styling */
        .alert {
            background: rgba(255, 255, 255, 0.95);
            backdrop-filter: blur(20px);
            border: none;
            border-radius: 15px;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.1);
            margin-bottom: 2rem;
        }

        .alert-success {
            border-left: 4px solid var(--success-color);
            color: var(--success-color);
        }

        /* Data Table */
        .data-table-container {
            background: rgba(255, 255, 255, 0.95);
            backdrop-filter: blur(20px);
            border-radius: 20px;
            box-shadow: 0 20px 40px rgba(0, 0, 0, 0.1);
            border: 1px solid rgba(255, 255, 255, 0.3);
            overflow: hidden;
        }

        .table-header {
            background: linear-gradient(135deg, var(--primary-color), var(--secondary-color));
            color: white;
            padding: 1.5rem 2rem;
            display: flex;
            align-items: center;
            gap: 1rem;
        }

        .table-title {
            font-size: 1.25rem;
            font-weight: 600;
            margin: 0;
        }

        .table-responsive {
            max-height: 600px;
            overflow-y: auto;
        }

        .modern-table {
            width: 100%;
            border-collapse: collapse;
            margin: 0;
        }

        .modern-table th {
            background: #f8fafc;
            padding: 1rem;
            text-align: left;
            font-weight: 600;
            color: #4a5568;
            border-bottom: 2px solid #e2e8f0;
            position: sticky;
            top: 0;
            z-index: 10;
        }

        .modern-table td {
            padding: 1rem;
            border-bottom: 1px solid #e2e8f0;
            color: #2d3748;
            vertical-align: middle;
        }

        .modern-table tbody tr {
            transition: all 0.2s ease;
        }

        .modern-table tbody tr:hover {
            background: rgba(102, 126, 234, 0.05);
            transform: scale(1.01);
        }

        /* Status Badge */
        .status-badge {
            padding: 8px 16px;
            border-radius: 20px;
            font-size: 0.875rem;
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            display: inline-block;
        }

        .status-active {
            background: linear-gradient(135deg, #48bb78, #38a169);
            color: white;
            box-shadow: 0 4px 15px rgba(72, 187, 120, 0.3);
        }

        .status-inactive {
            background: linear-gradient(135deg, #f56565, #e53e3e);
            color: white;
            box-shadow: 0 4px 15px rgba(245, 101, 101, 0.3);
        }

        /* Action Buttons */
        .action-btn {
            border: none;
            padding: 0.5rem 1rem;
            border-radius: 10px;
            cursor: pointer;
            transition: all 0.3s ease;
            text-decoration: none;
            display: inline-flex;
            align-items: center;
            gap: 0.5rem;
            font-size: 0.875rem;
            margin-right: 0.5rem;
            font-weight: 500;
        }

        .btn-toggle-active {
            background: linear-gradient(135deg, #ed8936, #dd6b20);
            color: white;
        }

        .btn-toggle-active:hover {
            background: linear-gradient(135deg, #dd6b20, #c05621);
            transform: translateY(-2px);
            box-shadow: 0 8px 20px rgba(237, 137, 54, 0.4);
            color: white;
        }

        .btn-toggle-inactive {
            background: linear-gradient(135deg, #48bb78, #38a169);
            color: white;
        }

        .btn-toggle-inactive:hover {
            background: linear-gradient(135deg, #38a169, #2f855a);
            transform: translateY(-2px);
            box-shadow: 0 8px 20px rgba(72, 187, 120, 0.4);
            color: white;
        }

        .btn-delete {
            background: linear-gradient(135deg, #f56565, #ef4444);
            color: white;
        }

        .btn-delete:hover {
            background: linear-gradient(135deg, #e53e3e, #dc2626);
            transform: translateY(-2px);
            box-shadow: 0 8px 20px rgba(245, 101, 101, 0.4);
            color: white;
        }

        /* Message Cell */
        .message-cell {
            max-width: 300px;
            word-wrap: break-word;
            white-space: normal;
        }

        /* Responsive Design */
        @media (max-width: 768px) {
            .sidebar {
                transform: translateX(-100%);
                transition: transform 0.3s ease;
            }

            .sidebar.open {
                transform: translateX(0);
            }

            .main-content {
                margin-left: 0;
            }

            .page-title {
                font-size: 2rem;
            }

            .modern-table {
                font-size: 0.875rem;
            }

            .modern-table th,
            .modern-table td {
                padding: 0.75rem 0.5rem;
            }

            .action-btn {
                padding: 0.375rem 0.75rem;
                font-size: 0.75rem;
            }
        }

        /* Custom Scrollbar */
        ::-webkit-scrollbar {
            width: 8px;
        }

        ::-webkit-scrollbar-track {
            background: rgba(255, 255, 255, 0.1);
            border-radius: 10px;
        }

        ::-webkit-scrollbar-thumb {
            background: linear-gradient(135deg, var(--primary-color), var(--secondary-color));
            border-radius: 10px;
        }

        ::-webkit-scrollbar-thumb:hover {
            background: linear-gradient(135deg, var(--secondary-color), var(--primary-color));
        }

        .modern-table tbody tr.selected {
            background: rgba(102, 126, 234, 0.1) !important;
            box-shadow: inset 3px 0 0 var(--primary-color);
        }
    </style>
</head>

<body>
    <!-- Top Navigation -->
    <nav class="top-nav d-flex justify-content-between align-items-center">
        <div class="d-flex align-items-center">
            <button class="btn btn-link d-md-none me-3" id="sidebarToggle">
                <i class="fas fa-bars"></i>
            </button>
            <a href="../../index.php" class="nav-brand">ADMIN PANEL</a>
        </div>
        <div class="nav-user">
            <div class="dropdown">
                <div class="nav-avatar" data-bs-toggle="dropdown">
                    <i class="fas fa-user"></i>
                </div>
                <ul class="dropdown-menu dropdown-menu-end">
                    <li><a class="dropdown-item" href="../logout.php">
                        <i class="fas fa-sign-out-alt me-2"></i>Logout
                    </a></li>
                </ul>
            </div>
        </div>
    </nav>

    <!-- Sidebar -->
    <nav class="sidebar" id="sidebar">
        <ul class="sidebar-menu">
            <li class="sidebar-item">
                <a href="index.php" class="sidebar-link">
                    <i class="fas fa-tachometer-alt sidebar-icon"></i>
                    Dashboard
                </a>
            </li>
            <li class="sidebar-item">
                <div class="px-4 py-2">
                    <small class="text-muted fw-bold">INTERFACE</small>
                </div>
            </li>
            <li class="sidebar-item">
                <a href="adds.php" class="sidebar-link">
                    <i class="fas fa-bullhorn sidebar-icon"></i>
                    Manage Ads
                </a>
            </li>
            <li class="sidebar-item">
                <a href="feedback.php" class="sidebar-link active">
                    <i class="fas fa-comments sidebar-icon"></i>
                    Manage Feedback
                </a>
            </li>
        </ul>
    </nav>

    <!-- Main Content -->
    <main class="main-content">
        <div class="page-header">
            <h1 class="page-title">Feedback Management</h1>
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item">Dashboard</li>
                    <li class="breadcrumb-item active">Manage Feedback</li>
                </ol>
            </nav>
        </div>

        <!-- Statistics Card -->
        <div class="stat-card">
            <div class="stat-icon">
                <i class="fas fa-comments"></i>
            </div>
            <div>
                <div class="stat-number"><?php echo $feedbackCount; ?></div>
                <div class="stat-label">Total Feedback</div>
            </div>
        </div>

        <!-- Success Message -->
        <?php if ($message): ?>
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            <i class="fas fa-check-circle me-2"></i>
            <?php echo htmlspecialchars($message); ?>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
        <?php endif; ?>

        <!-- Feedback Table -->
        <div class="data-table-container">
            <div class="table-header">
                <i class="fas fa-comments"></i>
                <h3 class="table-title">User Feedback</h3>
            </div>
            <div class="table-responsive">
                <table class="modern-table">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>User Name</th>
                            <th>Email</th>
                            <th>Message</th>
                            <th>Status</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        if ($result && $result->num_rows > 0) {
                            while ($row = $result->fetch_assoc()) {
                                $statusClass = $row['status'] === 'active' ? 'status-active' : 'status-inactive';
                                echo "<tr>";
                                echo "<td>#" . htmlspecialchars($row['feedback_id']) . "</td>";
                                echo "<td>" . htmlspecialchars($row['name']) . "</td>";
                                echo "<td>" . htmlspecialchars($row['email']) . "</td>";
                                echo "<td class='message-cell'>" . htmlspecialchars($row['message']) . "</td>";
                                echo "<td><span class='status-badge " . $statusClass . "'>" . ucfirst(htmlspecialchars($row['status'])) . "</span></td>";
                                echo "<td>
                                        <a href='feedback.php?action=toggle_status&id=" . $row['feedback_id'] . "' 
                                           class='action-btn " . ($row['status'] === 'active' ? 'btn-toggle-active' : 'btn-toggle-inactive') . "'>
                                           <i class='fas fa-exchange-alt'></i> " .
                                          ($row['status'] === 'active' ? 'Deactivate' : 'Activate') . "
                                        </a>
                                        <a href='feedback.php?action=delete&id=" . $row['feedback_id'] . "' 
                                           class='action-btn btn-delete'
                                           onclick='return confirm(\"Are you sure you want to delete this feedback?\");'>
                                           <i class='fas fa-trash'></i> Delete
                                        </a>
                                      </td>";
                                echo "</tr>";
                            }
                        } else {
                            echo "<tr><td colspan='6' class='text-center py-4'>
                                    <i class='fas fa-comments fa-3x text-muted mb-3 d-block'></i>
                                    <div class='text-muted'>No feedback found</div>
                                  </td></tr>";
                        }
                        ?>
                    </tbody>
                </table>
            </div>
        </div>
    </main>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        // Sidebar Toggle for Mobile
        document.getElementById('sidebarToggle')?.addEventListener('click', function() {
            document.getElementById('sidebar').classList.toggle('open');
        });

        // Add loading animation to stat numbers
        document.addEventListener('DOMContentLoaded', function() {
            const statNumbers = document.querySelectorAll('.stat-number');
            statNumbers.forEach(number => {
                const finalValue = parseInt(number.textContent);
                let currentValue = 0;
                const increment = finalValue / 50;
                const timer = setInterval(() => {
                    currentValue += increment;
                    if (currentValue >= finalValue) {
                        number.textContent = finalValue;
                        clearInterval(timer);
                    } else {
                        number.textContent = Math.floor(currentValue);
                    }
                }, 30);
            });
        });

        // Add smooth hover effects
        document.querySelectorAll('.stat-card').forEach(card => {
            card.addEventListener('mouseenter', function() {
                this.style.transform = 'translateY(-5px) scale(1.02)';
            });
            
            card.addEventListener('mouseleave', function() {
                this.style.transform = 'translateY(0) scale(1)';
            });
        });

        // Enhanced table row interactions
        document.querySelectorAll('.modern-table tbody tr').forEach(row => {
            row.addEventListener('click', function(e) {
                if (!e.target.closest('.action-btn')) {
                    // Add selection highlight
                    document.querySelectorAll('.modern-table tbody tr').forEach(r => r.classList.remove('selected'));
                    this.classList.add('selected');
                }
            });
        });

        // Auto-dismiss alerts after 5 seconds
        setTimeout(function() {
            const alerts = document.querySelectorAll('.alert');
            alerts.forEach(alert => {
                const bsAlert = new bootstrap.Alert(alert);
                bsAlert.close();
            });
        }, 5000);
    </script>
</body>

</html>