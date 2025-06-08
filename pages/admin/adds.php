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
  <meta name="description" content="" />
  <meta name="author" content="" />
  <title>Manage Vehicles - ManualLK</title>
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

    /* Alert Messages */
    .custom-alert {
      background: rgba(72, 187, 120, 0.1);
      backdrop-filter: blur(20px);
      border: 1px solid rgba(72, 187, 120, 0.3);
      border-radius: 15px;
      color: var(--success-color);
      padding: 1rem 1.5rem;
      margin-bottom: 2rem;
      box-shadow: 0 8px 25px rgba(72, 187, 120, 0.2);
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
      max-height: 800px;
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

    /* Vehicle Image Styling */
    .vehicle-image {
      width: 80px;
      height: 60px;
      object-fit: cover;
      border-radius: 10px;
      box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1);
      transition: all 0.3s ease;
    }

    .vehicle-image:hover {
      transform: scale(1.2);
      box-shadow: 0 8px 25px rgba(0, 0, 0, 0.2);
    }

    /* Status Badge */
    .status-badge {
      padding: 0.5rem 1rem;
      border-radius: 25px;
      font-size: 0.875rem;
      font-weight: 600;
      display: inline-flex;
      align-items: center;
      gap: 0.5rem;
    }

    .status-active {
      background: linear-gradient(135deg, rgba(72, 187, 120, 0.2), rgba(72, 187, 120, 0.1));
      color: var(--success-color);
      border: 1px solid rgba(72, 187, 120, 0.3);
    }

    .status-inactive {
      background: linear-gradient(135deg, rgba(245, 101, 101, 0.2), rgba(245, 101, 101, 0.1));
      color: var(--danger-color);
      border: 1px solid rgba(245, 101, 101, 0.3);
    }

    /* Action Buttons */
    .action-btn {
      padding: 0.5rem 1rem;
      border: none;
      border-radius: 10px;
      cursor: pointer;
      transition: all 0.3s ease;
      text-decoration: none;
      display: inline-flex;
      align-items: center;
      gap: 0.5rem;
      font-size: 0.875rem;
      font-weight: 600;
      margin-right: 0.5rem;
      margin-bottom: 0.5rem;
    }

    .btn-toggle {
      background: linear-gradient(135deg, var(--warning-color), #f6ad55);
      color: white;
    }

    .btn-toggle:hover {
      background: linear-gradient(135deg, #dd6b20, var(--warning-color));
      transform: translateY(-2px);
      box-shadow: 0 8px 20px rgba(237, 137, 54, 0.4);
      color: white;
    }

    .btn-toggle.activate {
      background: linear-gradient(135deg, var(--success-color), #68d391);
    }

    .btn-toggle.activate:hover {
      background: linear-gradient(135deg, #38a169, var(--success-color));
      box-shadow: 0 8px 20px rgba(72, 187, 120, 0.4);
    }

    .btn-delete {
      background: linear-gradient(135deg, var(--danger-color), #ef4444);
      color: white;
    }

    .btn-delete:hover {
      background: linear-gradient(135deg, #e53e3e, #dc2626);
      transform: translateY(-2px);
      box-shadow: 0 8px 20px rgba(245, 101, 101, 0.4);
      color: white;
    }

    /* Price Styling */
    .price-display {
      font-weight: 700;
      color: var(--primary-color);
      font-size: 1.1rem;
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

      .vehicle-image {
        width: 60px;
        height: 45px;
      }
    }

    /* Loading Animation */
    @keyframes pulse {
      0%, 100% { opacity: 1; }
      50% { opacity: 0.5; }
    }

    .loading {
      animation: pulse 2s infinite;
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

    /* Enhanced table selection */
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
        <a href="adds.php" class="sidebar-link active">
          <i class="fas fa-car sidebar-icon"></i>
          Manage Ads
        </a>
      </li>
      <li class="sidebar-item">
        <a href="feedback.php" class="sidebar-link">
          <i class="fas fa-comments sidebar-icon"></i>
          Manage Feedback
        </a>
      </li>
    </ul>
  </nav>

  <!-- Main Content -->
  <main class="main-content">
    <div class="page-header">
      <h1 class="page-title">Manage Vehicles</h1>
      <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
          <li class="breadcrumb-item">Dashboard</li>
          <li class="breadcrumb-item active">Manage Vehicles</li>
        </ol>
      </nav>
    </div>

    <?php if ($message): ?>
    <div class="custom-alert">
      <i class="fas fa-check-circle me-2"></i>
      <?php echo htmlspecialchars($message); ?>
    </div>
    <?php endif; ?>

    <!-- Vehicles Table -->
    <div class="data-table-container">
      <div class="table-header">
        <i class="fas fa-car"></i>
        <h3 class="table-title">Vehicle Listings</h3>
      </div>
      <div class="table-responsive">
        <table class="modern-table">
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
                    $toggleClass = $row['status'] === 'active' ? 'btn-toggle' : 'btn-toggle activate';
                    $toggleText = $row['status'] === 'active' ? 'Deactivate' : 'Activate';
                    $toggleIcon = $row['status'] === 'active' ? 'fas fa-pause' : 'fas fa-play';
                    
                    echo "<tr>";
                    echo "<td><img src='../../uploads/" . htmlspecialchars($row['image']) . "' class='vehicle-image' alt='Vehicle'></td>";
                    echo "<td><strong>" . htmlspecialchars($row['make'] . " " . $row['model']) . "</strong></td>";
                    echo "<td>" . htmlspecialchars($row['year']) . "</td>";
                    echo "<td>" . htmlspecialchars($row['v_type']) . "</td>";
                    echo "<td>" . htmlspecialchars($row['condition']) . "</td>";
                    echo "<td><span class='price-display'>LKR " . number_format(str_replace(',', '', $row['price'])) . "</span></td>";
                    echo "<td>" . htmlspecialchars($row['city']) . "</td>";
                    echo "<td><span class='status-badge " . $statusClass . "'>";
                    echo "<i class='fas fa-" . ($row['status'] === 'active' ? 'check' : 'times') . "'></i>";
                    echo ucfirst(htmlspecialchars($row['status'])) . "</span></td>";
                    echo "<td>
                            <a href='adds.php?action=toggle_status&id=" . $row['id'] . "' 
                               class='action-btn " . $toggleClass . "'>
                               <i class='" . $toggleIcon . "'></i> " . $toggleText . "
                            </a>
                            <a href='adds.php?action=delete&id=" . $row['id'] . "' 
                               class='action-btn btn-delete'
                               onclick='return confirm(\"Are you sure you want to delete this vehicle? This will also delete the associated image.\");'>
                               <i class='fas fa-trash'></i> Delete
                            </a>
                          </td>";
                    echo "</tr>";
                }
            } else {
                echo "<tr><td colspan='9' class='text-center py-4'>
                        <i class='fas fa-car fa-3x text-muted mb-3 d-block'></i>
                        <div class='text-muted'>No vehicles found</div>
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

    // Add hover effects to action buttons
    document.querySelectorAll('.action-btn').forEach(btn => {
      btn.addEventListener('mouseenter', function() {
        this.style.transform = 'translateY(-2px) scale(1.05)';
      });
      
      btn.addEventListener('mouseleave', function() {
        this.style.transform = 'translateY(0) scale(1)';
      });
    });

    // Add loading effect when buttons are clicked
    document.querySelectorAll('.action-btn').forEach(btn => {
      btn.addEventListener('click', function() {
        if (!this.classList.contains('btn-delete') || confirm('Are you sure?')) {
          this.innerHTML = '<i class="fas fa-spinner fa-spin"></i> Processing...';
          this.style.pointerEvents = 'none';
        }
      });
    });
  </script>
</body>

</html>