<?php
session_start();  
include_once '../../includes/dbconnect.php';

// Fetch all users from database
$sql = "SELECT * FROM users ORDER BY id DESC";
$result = $conn->query($sql);

// Count total users
$userCount = $conn->query("SELECT COUNT(*) as count FROM users")->fetch_assoc()['count'];

// Count total vehicles
$vehicleCount = $conn->query("SELECT COUNT(*) as count FROM vehicle")->fetch_assoc()['count'];

// Count total feedback
$feedbackCount = $conn->query("SELECT COUNT(*) as count FROM feedback")->fetch_assoc()['count'];
?>


<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8" />
  <meta http-equiv="X-UA-Compatible" content="IE=edge" />
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
  <meta name="description" content="" />
  <meta name="author" content="" />
  <title>Dashboard - ManualLK</title>
  <link rel="icon" type="image/png" href="assets\images\logotransp.png">

  <!-- stylesheet table and site -->
  <link href="css/styles.css" rel="stylesheet" />
  <script src="https://use.fontawesome.com/releases/v6.3.0/js/all.js" crossorigin="anonymous"></script>

  <!-- stylesheet card -->
  <style>
    .card {
      border-radius: 10px;
      box-shadow: 0 10px 20px rgba(0, 0, 0, 0.19), 0 6px 6px rgba(0, 0, 0, 0.23);
    }

    .card-body {
      display: flex;
      flex-direction: column;
      justify-content: center;
      padding: 20px;
      background-color: #1a2d41;
      color: white;
    }

    .card-body i {
      font-size: 50px;
      margin-bottom: 20px;
    }

    .card-body h3 {
      font-weight: 700;
      margin-bottom: 10px;
    }

    .card-body span {
      font-size: 15px;
    }
  </style>
</head>

<body class="sb-nav-fixed">
  <nav class="sb-topnav navbar navbar-expand navbar-dark bg-dark">
    <a class="navbar-brand ps-3" href="index.html">ADIMIN PANEL</a>
    <button class="btn btn-link btn-sm order-1 order-lg-0 me-4 me-lg-0" id="sidebarToggle" href="#!">
      <i class="fas fa-bars"></i>
    </button>
    <form class="d-none d-md-inline-block form-inline ms-auto me-0 me-md-3 my-2 my-md-0">
      <div class="input-group"></div>
    </form>
    <ul class="navbar-nav ms-auto ms-md-0 me-3 me-lg-4">
      <li class="nav-item dropdown">
        <a class="nav-link dropdown-toggle" id="navbarDropdown" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false"><i class="fas fa-user fa-fw"></i></a>
        <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="navbarDropdown">
          <li><a class="dropdown-item" href="../logout.php">Logout</a></li>
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
            <a class="nav-link collapsed" href="#" data-bs-toggle="collapse" data-bs-target="#collapseLayouts" aria-expanded="false" aria-controls="collapseLayouts">
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
                <a class="nav-link" href="adds.php">Manage Adds</a>
                <a class="nav-link" href="feedback.php">Manage Feedbacks</a>
              </nav>
            </div>
            <a class="nav-link collapsed" href="#" data-bs-toggle="collapse" data-bs-target="#collapsePages" aria-expanded="false" aria-controls="collapseLayouts">
              <div class="sb-nav-link-icon">
               
              </div>
             
              <a class="nav-link" href="#">
                
              </a>
          </div>
        </div>
        <div class="sb-sidenav-footer"></div>
      </nav>
    </div>
    <div id="layoutSidenav_content">
      <main>
        <div class="container-fluid px-4">
          <h1 class="mt-4">Dashboard</h1>
          <ol class="breadcrumb mb-4">
            <li class="breadcrumb-item active">Dashboard</li>
          </ol>

          <div class="grey-bg container-fluid">
            <section id="minimal-statistics">
              <div class="row mb-4">
                <!-- Users Card -->
                <div class="col-xl-4 col-sm-6 col-12 mb-4">
                  <div class="card">
                    <div class="card-body">
                      <div class="d-flex justify-content-between px-md-1">
                        <div>
                          <h3 class="text-warning"><?php echo $userCount; ?></h3>
                          <p class="mb-0">Total Users</p>
                        </div>
                        <div class="align-self-center">
                          <i class="fas fa-users text-warning fa-3x"></i>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>

                <!-- Vehicles Card -->
                <div class="col-xl-4 col-sm-6 col-12 mb-4">
                  <div class="card">
                    <div class="card-body">
                      <div class="d-flex justify-content-between px-md-1">
                        <div>
                          <h3 class="text-success"><?php echo $vehicleCount; ?></h3>
                          <p class="mb-0">Total Vehicles</p>
                        </div>
                        <div class="align-self-center">
                          <i class="fas fa-car text-success fa-3x"></i>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>

                <!-- Feedback Card -->
                <div class="col-xl-4 col-sm-6 col-12 mb-4">
                  <div class="card">
                    <div class="card-body">
                      <div class="d-flex justify-content-between px-md-1">
                        <div>
                          <h3 class="text-info"><?php echo $feedbackCount; ?></h3>
                          <p class="mb-0">Total Feedback</p>
                        </div>
                        <div class="align-self-center">
                          <i class="fas fa-comments text-info fa-3x"></i>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </section>
          </div>


          <div class="card mb-4">
            <div class="card-header">
              <i class="fas fa-table me-1"></i>
              All users
            </div>
            <div class="card-body bg-light">
              <table class="table text-start align-middle table-bordered table-hover mb-0">
                <thead>
                  <tr class="text-dark">
                    <th scope="col">Id</th>
                    <th scope="col">User Name</th>
                    <th scope="col">Email</th>
                    <th scope="col">Contact</th>
                    <th scope="col">Action</th>
                  </tr>
                </thead>
                <tbody>
                  <?php
                  if ($result->num_rows > 0) {
                    while($row = $result->fetch_assoc()) {
                      echo "<tr>";
                      echo "<td>" . htmlspecialchars($row['id']) . "</td>";
                      echo "<td>" . htmlspecialchars($row['first_name'] . " " . $row['last_name']) . "</td>";
                      echo "<td>" . htmlspecialchars($row['email']) . "</td>";
                      echo "<td>" . htmlspecialchars($row['contact']) . "</td>";
                      echo "<td>
                              <a href='./delete_user.php?id=" . $row['id'] . "' class='btn btn-sm btn-danger' onclick='return confirm(\"Are you sure you want to delete this user?\");'>
                                <i class='fas fa-trash'></i> Delete
                              </a>
                           </td>";
                      echo "</tr>";
                    }
                  } else {
                    echo "<tr><td colspan='5' class='text-center'>No users found</td></tr>";
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
          <div class="d-flex align-items-center justify-content-between small">
            <div class="text-muted">
              Copyright &copy; ManualLK
            </div>
          </div>
        </div>
      </footer>
    </div>
  </div>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js" crossorigin="anonymous"></script>
  <script src="js/scripts.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.8.0/Chart.min.js" crossorigin="anonymous"></script>
  <script src="assets/demo/chart-area-demo.js"></script>
  <script src="assets/demo/chart-bar-demo.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/simple-datatables@7.1.2/dist/umd/simple-datatables.min.js" crossorigin="anonymous"></script>
  <script src="js/datatables-simple-demo.js"></script>
</body>

</html>