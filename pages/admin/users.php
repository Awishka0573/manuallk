<?php
include_once "../../inc/db_connect.php";
session_start();

// Fetch all users initially
$sql = "SELECT * FROM users";
$users = mysqli_query($conn, $sql);

// Filter by User Type
$user_type_filter = isset($_POST['user_type']) ? $_POST['user_type'] : '';
$email_search = isset($_POST['email_search']) ? $_POST['email_search'] : '';

$sql = "SELECT * FROM users WHERE 1=1";
if (!empty($user_type_filter)) {
    $sql .= " AND user_type = '" . mysqli_real_escape_string($conn, $user_type_filter) . "'";
}
if (!empty($email_search)) {
    $sql .= " AND email LIKE '%" . mysqli_real_escape_string($conn, $email_search) . "%'";
}

$users = mysqli_query($conn, $sql);

// Handle Update or Delete Actions
if (isset($_POST["id"])) {
    $id = $_POST["id"];
    if (isset($_POST["userType"])) {
        $userType = $_POST["userType"];
        $sql = "UPDATE users SET user_type = '$userType' WHERE id=$id";
    } else {
        $sql = "DELETE FROM users WHERE id=$id";
    }
    $conn->query($sql);
    exit();
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
    <title>Manage Users</title>
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
                <div class="container-fluid px-4">
                    <h1 class="mt-4">Manage Users</h1>

                    <!-- Filter and Search Forms -->
                    <form method="POST" action="" class="row g-3 mb-4">
                        <div class="col-md-4">
                            <label for="user_type" class="form-label">Filter by User Type:</label>
                            <select class="form-select" id="user_type" name="user_type" onchange="this.form.submit()">
                                <option value="">All</option>
                                <option value="admin" <?= $user_type_filter == 'admin' ? 'selected' : '' ?>>Admin</option>
                                <option value="lecture" <?= $user_type_filter == 'lecture' ? 'selected' : '' ?>>Lecture</option>
                                <option value="student" <?= $user_type_filter == 'student' ? 'selected' : '' ?>>Student</option>
                            </select>
                        </div>
                        <div class="col-md-4">
                            <label for="email_search" class="form-label">Search by Email:</label>
                            <input type="text" class="form-control" id="email_search" name="email_search" placeholder="Enter email" value="<?= htmlspecialchars($email_search) ?>">
                        </div>
                        <div class="col-md-2 d-flex align-items-end">
                            <button type="submit" class="btn btn-primary">Search</button>
                        </div>
                    </form>

                    <!-- Users Table -->
                    <table class="table align-middle mb-0 bg-white">
                        <thead class="bg-light">
                            <tr>
                                <th>Name</th>
                                <th>Email</th>
                                <th>Current User Type</th>
                                <th>Update User Type</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($users as $user) { ?>
                                <tr>
                                    <td><?= htmlspecialchars($user['fullname']) ?></td>
                                    <td><?= htmlspecialchars($user['email']) ?></td>
                                    <td>
                                        <button class="btn btn-sm btn-<?= $user['user_type'] == 'admin' ? 'primary' : ($user['user_type'] == 'lecture' ? 'success' : 'info') ?>">
                                            <?= ucfirst($user['user_type']) ?>
                                        </button>
                                    </td>
                                    <td>
                                        <select class="form-select" onchange="updateUserType(<?= $user['id'] ?>, this.value)">
                                            <option value="student" <?= $user['user_type'] == 'student' ? 'selected' : '' ?>>Student</option>
                                            <option value="admin" <?= $user['user_type'] == 'admin' ? 'selected' : '' ?>>Admin</option>
                                            <option value="lecture" <?= $user['user_type'] == 'lecture' ? 'selected' : '' ?>>Lecture</option>
                                        </select>
                                    </td>
                                    <td>
                                        <button class="btn btn-danger btn-sm" onclick="deleteUser(<?= $user['id'] ?>)">Delete</button>
                                    </td>
                                </tr>
                            <?php } ?>
                        </tbody>
                    </table>
                </div>
            </main>
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
    <script src="js/scripts.js"></script>

    <script>
        function deleteUser(userId) {
            const xhr = new XMLHttpRequest();
            xhr.open('POST', 'users.php');
            xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
            xhr.onload = () => {
                if (xhr.status === 200) window.location.reload();
            };
            xhr.send(`id=${userId}`);
        }

        function updateUserType(userId, userType) {
            const xhr = new XMLHttpRequest();
            xhr.open('POST', 'users.php');
            xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
            xhr.onload = () => {
                if (xhr.status === 200) window.location.reload();
            };
            xhr.send(`id=${userId}&userType=${userType}`);
        }
    </script>
</body>

</html>