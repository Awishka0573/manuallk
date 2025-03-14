<!-- <?php
// Session_start();
// include('../../inc/db_connect.php');


// $studentCount = $conn->query("SELECT COUNT(*) AS count FROM users WHERE user_type = 'student'")->fetch_assoc()['count'];
// $lecturerCount = $conn->query("SELECT COUNT(*) AS count FROM users WHERE user_type = 'lecture'")->fetch_assoc()['count'];
// $subjectCount = $conn->query("SELECT COUNT(*) AS count FROM subject")->fetch_assoc()['count'];
// $feedbackCount = $conn->query("SELECT COUNT(*) AS count FROM feedback")->fetch_assoc()['count'];


// $sql = "SELECT id, fullname, email, contact, address, user_type FROM users";
// $result = $conn->query($sql);

// $conn->close();
?> -->


<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8" />
  <meta http-equiv="X-UA-Compatible" content="IE=edge" />
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
  <meta name="description" content="" />
  <meta name="author" content="" />
  <title>Dashboard - LMS Admin</title>

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
                <a class="nav-link" href="users.php">Manage Sellers</a>
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
                  <!-- <i class="fas fa-chart-area"></i> -->
                </div>
                <!-- Students Feedback -->
              </a>
          </div>
        </div>
        <div class="sb-sidenav-footer">
          <!-- <div class="small">Logged in as:</div> -->
          <!-- <?php echo $_SESSION['admin_name'] ?> -->
        </div>
      </nav>
    </div>
    <div id="layoutSidenav_content">
      <main>
        <div class="container-fluid px-4">
          <h1 class="mt-4">Dashboard</h1>
          <ol class="breadcrumb mb-4">
            <li class="breadcrumb-item active">Dashboard</li>
          </ol>

          <!-- slide card start -->

          <div class="grey-bg container-fluid">
            <section id="minimal-statistics">
              <div class="row mb-3">
                <!-- Student Count -->
                <!-- <div class="col-xl-3 col-sm-6 col-12 mb-2">
                  <div class="card">
                    <div class="card-content">
                      <div class="card-body">
                        <div class="media d-flex">
                          <div class="align-self-center">
                            <i class="icon-pencil primary font-large-2 float-left"></i>
                          </div>
                          <div class="media-body text-right">
                            <h3><?php echo $studentCount; ?></h3>
                            <span>All Students</span>
                          </div>
                        </div>
                      </div>
                    </div>
                  </div>
                </div> -->
                <!-- Lecturer Count -->
                <!-- <div class="col-xl-3 col-sm-6 col-12 mb-2">
                  <div class="card">
                    <div class="card-content">
                      <div class="card-body">
                        <div class="media d-flex">
                          <div class="align-self-center">
                            <i class="icon-speech warning font-large-2 float-left"></i>
                          </div>
                          <div class="media-body text-right">
                            <h3><?php echo $lecturerCount; ?></h3>
                            <span>All Lectures</span>
                          </div>
                        </div>
                      </div>
                    </div>
                  </div>
                </div> -->
                <!-- Subject Count -->
                <!-- <div class="col-xl-3 col-sm-6 col-12 mb-2">
                  <div class="card">
                    <div class="card-content">
                      <div class="card-body">
                        <div class="media d-flex">
                          <div class="align-self-center">
                            <i class="icon-graph success font-large-2 float-left"></i>
                          </div>
                          <div class="media-body text-right">
                            <h3><?php echo $subjectCount; ?></h3>
                            <span>All Subjects</span>
                          </div>
                        </div>
                      </div>
                    </div>
                  </div>
                </div> -->
                <!-- Feedback Count -->
                <!-- <div class="col-xl-3 col-sm-6 col-12 mb-2">
                  <div class="card">
                    <div class="card-content">
                      <div class="card-body">
                        <div class="media d-flex">
                          <div class="align-self-center">
                            <i class="icon-pointer danger font-large-2 float-left"></i>
                          </div>
                          <div class="media-body text-right">
                            <h3><?php echo $feedbackCount; ?></h3>
                            <span>All Feedback</span>
                          </div>
                        </div>
                      </div>
                    </div>
                  </div>
                </div> -->
              </div>
            </section>
          </div>


          <!-- <div class="row">
                            <div class="col-xl-3 col-md-6">
                                <div class="card bg-primary text-white mb-4">
                                    <div class="card-body">Primary Card</div>
                                    <div class="card-footer d-flex align-items-center justify-content-between">
                                        <a class="small text-white stretched-link" href="#">View Details</a>
                                        <div class="small text-white"><i class="fas fa-angle-right"></i></div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-xl-3 col-md-6">
                                <div class="card bg-warning text-white mb-4">
                                    <div class="card-body">Warning Card</div>
                                    <div class="card-footer d-flex align-items-center justify-content-between">
                                        <a class="small text-white stretched-link" href="#">View Details</a>
                                        <div class="small text-white"><i class="fas fa-angle-right"></i></div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-xl-3 col-md-6">
                                <div class="card bg-success text-white mb-4">
                                    <div class="card-body">Success Card</div>
                                    <div class="card-footer d-flex align-items-center justify-content-between">
                                        <a class="small text-white stretched-link" href="#">View Details</a>
                                        <div class="small text-white"><i class="fas fa-angle-right"></i></div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-xl-3 col-md-6">
                                <div class="card bg-danger text-white mb-4">
                                    <div class="card-body">Danger Card</div>
                                    <div class="card-footer d-flex align-items-center justify-content-between">
                                        <a class="small text-white stretched-link" href="#">View Details</a>
                                        <div class="small text-white"><i class="fas fa-angle-right"></i></div>
                                    </div>
                                </div>
                            </div>
                        </div> -->

          <!-- slide card stop -->

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
                    <th scope="col">Address</th>
                    <th scope="col">User Type</th>
                  </tr>
                </thead>
                <tbody>
                  <?php
                //   if ($result->num_rows > 0) {
                //     // Output data of each row
                //     while ($row = $result->fetch_assoc()) {
                //       echo "<tr>
                //     <td>{$row['id']}</td>
                //     <td>{$row['fullname']}</td>
                //     <td>{$row['email']}</td>
                //     <td>{$row['contact']}</td>
                //     <td>{$row['address']}</td>
                //     <td>{$row['user_type']}</td>
                // </tr>";
                //     }
                //   } else {
                //     echo "<tr><td colspan='5'>No users found</td></tr>";
                //   }
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
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js"
    crossorigin="anonymous"></script>
  <script src="js/scripts.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.8.0/Chart.min.js" crossorigin="anonymous"></script>
  <script src="assets/demo/chart-area-demo.js"></script>
  <script src="assets/demo/chart-bar-demo.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/simple-datatables@7.1.2/dist/umd/simple-datatables.min.js"
    crossorigin="anonymous"></script>
  <script src="js/datatables-simple-demo.js"></script>
</body>

</html>