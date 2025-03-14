<?php
include_once "../../inc/db_connect.php";
session_start();

$filter_status = $_POST['filter_status'] ?? '';
$search_username = $_POST['search_username'] ?? '';

// Initialize Query
$query = "SELECT f_id, f_name AS `Student Name`, f_email AS `Email`, comment AS `Message`, create_date AS `Date`, status FROM feedback";

// Handle Filter Submission
if (isset($_POST['apply_filter'])) {
    if ($filter_status !== '') {
        $query .= " WHERE status = " . intval($filter_status);
    }
}

// Handle Search Submission
if (isset($_POST['apply_search'])) {
    if (!empty($search_username)) {
        $condition = "f_name LIKE '%" . mysqli_real_escape_string($conn, $search_username) . "%'";
        if (strpos($query, 'WHERE') !== false) {
            $query .= " AND $condition";
        } else {
            $query .= " WHERE $condition";
        }
    }
}

$result = $conn->query($query);

if (!$result) {
    die("Query failed: " . $conn->error);
}

// Handle Publish Action
if (isset($_POST['publish']) && isset($_POST['f_id'])) {
    $feedback_id = intval($_POST['f_id']);
    $updateQuery = "UPDATE feedback SET status = 1 WHERE f_id = $feedback_id";

    if ($conn->query($updateQuery)) {
        header("Location: " . $_SERVER['PHP_SELF']);
        exit();
    }
}

// Handle Delete Action
if (isset($_POST['delete']) && isset($_POST['f_id'])) {
    $feedback_id = intval($_POST['f_id']);
    $deleteQuery = "DELETE FROM feedback WHERE f_id = $feedback_id";

    if ($conn->query($deleteQuery)) {
        header("Location: " . $_SERVER['PHP_SELF']);
        exit();
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
    <title>Feedback Management</title>
    <link href="css/styles.css" rel="stylesheet" />
    <script src="https://use.fontawesome.com/releases/v6.3.0/js/all.js" crossorigin="anonymous"></script>
</head>

<body>
    <!-- Navigation -->
    <nav class="sb-topnav navbar navbar-expand navbar-dark bg-dark">
        <!-- Navbar Brand-->
        <a class="navbar-brand ps-3" href="index.html">ADIMIN PANEL</a>
        <!-- Sidebar Toggle-->
        <button class="btn btn-link btn-sm order-1 order-lg-0 me-4 me-lg-0" id="sidebarToggle" href="#!">
            <i class="fas fa-bars"></i>
        </button>
        <!-- Navbar Search-->
        <form class="d-none d-md-inline-block form-inline ms-auto me-0 me-md-3 my-2 my-md-0">
            <div class="input-group">
            </div>
        </form>
        <!-- Navbar-->
        <ul class="navbar-nav ms-auto ms-md-0 me-3 me-lg-4">
            <li class="nav-item dropdown">
                <a class="nav-link dropdown-toggle" id="navbarDropdown" href="#" role="button" data-bs-toggle="dropdown"
                    aria-expanded="false"><i class="fas fa-user fa-fw"></i></a>
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
                            <div class="sb-nav-link-icon">
                                <i class="fas fa-tachometer-alt"></i>
                            </div>
                            Dashboard
                        </a>
                        <div class="sb-sidenav-menu-heading">Interface</div>
                        <a class="nav-link collapsed" href="#" data-bs-toggle="collapse" data-bs-target="#collapseLayouts"
                            aria-expanded="false" aria-controls="collapseLayouts">
                            <div class="sb-nav-link-icon">
                                <i class="fas fa-columns"></i>
                            </div>
                            Manage
                            <div class="sb-sidenav-collapse-arrow">
                                <i class="fas fa-angle-down"></i>
                            </div>
                        </a>
                        <div class="collapse" id="collapseLayouts" aria-labelledby="headingOne" data-bs-parent="#sidenavAccordion">
                            <nav class="sb-sidenav-menu-nested nav">
                                <a class="nav-link" href="users.php">Manage Users</a>
                                <a class="nav-link" href="subject.php">Manage Subject</a>
                            </nav>
                        </div>
                        <a class="nav-link collapsed" href="#" data-bs-toggle="collapse" data-bs-target="#collapsePages"
                            aria-expanded="false" aria-controls="collapseLayouts">
                            <div class="sb-nav-link-icon">
                                <i class="fas fa-book-open"></i>
                            </div>

                            <div class="sb-sidenav-menu-heading">User review</div>
                            <a class="nav-link" href="./student_feedback.php">
                                <div class="sb-nav-link-icon">
                                    <i class="fas fa-chart-area"></i>
                                </div>
                                Students Feedback
                            </a>
                    </div>
                </div>
                <div class="sb-sidenav-footer">
                    <div class="small">Logged in as:</div>
                    <?php echo $_SESSION['admin_name'] ?>
                </div>
            </nav>
        </div>

        <div id="layoutSidenav_content">
            <main>
                <div class="container mt-5">
                    <h2 class="mb-4">Feedback Management</h2>

                    <!-- Filter Form -->
                    <form method="POST" action="" class="mb-4">
                        <div class="row">
                            <div class="col-md-6">
                                <label for="filterStatus" class="form-label">Filter by Status:</label>
                                <select name="filter_status" id="filterStatus" class="form-select">
                                    <option value="" <?php echo $filter_status === '' ? 'selected' : ''; ?>>All</option>
                                    <option value="1" <?php echo $filter_status === '1' ? 'selected' : ''; ?>>Published</option>
                                    <option value="0" <?php echo $filter_status === '0' ? 'selected' : ''; ?>>Unpublished</option>
                                </select>
                            </div>
                            <div class="col-md-6 d-flex align-items-end">
                                <button type="submit" name="apply_filter" class="btn btn-primary">Apply Filter</button>
                            </div>
                        </div>
                    </form>

                    <!-- Search Form -->
                    <form method="POST" action="" class="mb-4">
                        <div class="row">
                            <div class="col-md-6">
                                <label for="searchUsername" class="form-label">Search by Username:</label>
                                <input type="text" name="search_username" id="searchUsername" class="form-control"
                                    value="<?php echo htmlspecialchars($search_username); ?>" placeholder="Enter username">
                            </div>
                            <div class="col-md-6 d-flex align-items-end">
                                <button type="submit" name="apply_search" class="btn btn-primary">Search</button>
                            </div>
                        </div>
                    </form>

                    <!-- Feedback Table -->
                    <?php if ($result->num_rows > 0) { ?>
                        <table class="table table-bordered">
                            <thead class="table-dark">
                                <tr>
                                    <th>Student Name</th>
                                    <th>Email</th>
                                    <th>Message</th>
                                    <th>Date</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php while ($row = $result->fetch_assoc()) { ?>
                                    <tr>
                                        <td><?php echo htmlspecialchars($row['Student Name']); ?></td>
                                        <td><?php echo htmlspecialchars($row['Email']); ?></td>
                                        <td><?php echo htmlspecialchars($row['Message']); ?></td>
                                        <td><?php echo htmlspecialchars($row['Date']); ?></td>
                                        <td>
                                            <form method="POST" action="">
                                                <input type="hidden" name="f_id" value="<?php echo $row['f_id']; ?>">
                                                <button type="submit" name="publish"
                                                    class="btn btn-success <?php echo $row['status'] == 1 ? 'disabled' : ''; ?>"
                                                    <?php echo $row['status'] == 1 ? 'disabled' : ''; ?>>
                                                    Publish
                                                </button>
                                                <button type="submit" name="delete" class="btn btn-danger">
                                                    Delete
                                                </button>
                                            </form>
                                        </td>
                                    </tr>
                                <?php } ?>
                            </tbody>
                        </table>
                    <?php } else { ?>
                        <p class="text-center">No feedback found for the selected filters.</p>
                    <?php } ?>
                </div>
            </main>

            <!-- Footer -->
            <footer class="py-4 bg-light mt-auto">
                <div class="container-fluid px-4">
                    <div class="d-flex align-items-center justify-content-between small">
                        <div class="text-muted">Copyright &copy; Lecture Management System Easy 2024</div>
                    </div>
                </div>
            </footer>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js" crossorigin="anonymous"></script>
    <script src="js/scripts.js"></script>
</body>

</html>