<?php
include_once "../../inc/db_connect.php";
session_start();

$sql = "SELECT * FROM subject";
$subjects = mysqli_query($conn, $sql);

if (isset($_POST["id"])) {
    $id = $_POST["id"];

    $sql = "DELETE FROM subject WHERE subject_id=$id";
    $conn->query($sql);
}

?>

<?php

if (isset($_POST['subject_id'])) {
    $subject_id = $_POST['subject_id'];
    $subject_name = $_POST['subject_name'];
    $subject_code = $_POST["subject_code"];

    $sql = "UPDATE subjects SET subject_code = ?, subject_name = ? WHERE subject_id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ssi", $subject_code, $subject_name, $subject_id);
    $stmt->execute();
 
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $subject_code = trim($_POST['subject_code']);
    $subject_name = trim($_POST['subject_name']);


    if (empty($subject_code) || empty($subject_name)) {
        header('location:./subject.php?massage=Subject code and subject name are required.!');
    } else {

        $stmt = $conn->prepare("INSERT INTO subject (subject_code, subject_name) VALUES (?, ?)");
        $stmt->bind_param("ss", $subject_code, $subject_name);

        if ($stmt->execute()) {
            header('location:./subject.php?massage=Subject added successfully!');
        } else {
            echo "Error: " . $stmt->error;
        }
        $stmt->close();
    }
}

?>
<a href="./subject.php"></a>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
    <meta name="description" content="" />
    <meta name="author" content="" />
    <title>Static Navigation - SB Admin</title>
    <link href="css/styles.css" rel="stylesheet" />
    <script src="https://use.fontawesome.com/releases/v6.3.0/js/all.js" crossorigin="anonymous"></script>
</head>

<body>
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
                <div class="container-fluid px-3 d-flex justify-content-between flex-wrap">
                    <div class="border boder-5 boder-red col-7 ">
                        <h1 class="mt-4">Subject Details</h1>
                        <ol class="breadcrumb mb-4">
                            <li class="breadcrumb-item">Dashboard</li>
                            <li class="breadcrumb-item active">Subject Details</li>
                        </ol>
                        <table class="table align-middle mb-0 bg-white ">
                            <thead class="bg-light">
                                <tr>
                                    <th>Name</th>
                                    <th>Code</th>
                                    <th>Actions</th>

                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                foreach ($subjects as $subject) {
                                ?>

                                    <tr>
                                        <form id="subjectUpdateForm">
                                            <td>
                                                <input type="hidden" name="subject_name" value="<?php echo $subject['subject_name'] ?>" class="form-control">
                                            </td>

                                            <td>
                                                <input type="text" name="subject_code" value="<?php echo $subject['subject_code'] ?>" class="form-control">
                                            </td>
                                            <td>
                                                <button type="submit" class="btn btn-success btn-sm" onclick="updateSubject(<?php echo $subject['subject_id'] ?>,event)">
                                                    update
                                                </button>
                                                <button type="button" class="btn btn-link btn-sm btn-rounded">
                                                    <i class="fas fa-trash-alt" onclick="deleteUser(<?php echo $subject['subject_id'] ?>,event)"></i>
                                                </button>
                                            </td>
                                        </form>
                                    </tr>
                                <?php } ?>


                            </tbody>
                        </table>
                        <!-- <div style="height: 100vh"></div>

                        <div class="card mb-4">
                            <div class="card-body">When scrolling, the navigation stays at the top of the page. This is the end of the static navigation demo.</div>
                        </div> -->
                    </div>

                    <div class="px-2 col-lg-5 col-md-12 mt-lg-0 mt-4">
                        <div class="card mt-5">
                            <div class="card-header bg-dark text-white">
                                <h2 class="mt-2">Add Subject</h2>
                            </div>
                            <div class="card-body">
                                <form method="POST" action="">
                                    <div class="form-floating mb-3">
                                        <input class="form-control" id="inputsubject" name="subject_code" type="text" placeholder="Subject Code" required />
                                        <label for="inputsubject">Add Subject Code</label>
                                    </div>
                                    <div class="form-floating mb-3">
                                        <input class="form-control" id="inputtext" name="subject_name" type="text" placeholder="Subject Name" required />
                                        <label for="inputtext">Add Subject Name</label>
                                    </div>
                                    <div class="d-flex align-items-center justify-content-between mt-4 mb-0">
                                        <button type="submit" class="btn btn-dark w-100">Add Subject</button>
                                    </div>
                                </form>
                            </div>
                        </div>

                    </div>
            </main>
            <footer class="py-4 bg-light mt-auto">
                <div class="container-fluid px-4">
                    <div class="d-flex align-items-center justify-content-between small">
                        <div class="text-muted">Copyright &copy; lecture Managment System easy 2024</div>
                    </div>
                </div>
            </footer>
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js" crossorigin="anonymous"></script>
    <script src="js/scripts.js"></script>

    <script>
        function deleteUser(subjectId, event) {
            const xhr = new XMLHttpRequest();
            xhr.open('POST', 'subject.php');
            xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
            xhr.onload = () => {
                if (xhr.status === 200) {
                    window.location.reload();
                }
            }
            xhr.send(`id=${subjectId}`);
        }



        function updateSubject(subjectId, event) {
            event.preventDefault(); // Prevent the form from submitting traditionally

            // Select the form fields
            const nameField = document.querySelector(`input[name="name"]`);
            const codeField = document.querySelector(`input[name="title"]`);

            const name = nameField.value.trim();
            const code = codeField.value.trim();

            if (!name || !code) {
                alert("Both subject name and code are required!");
                return;
            }

            // Prepare the AJAX request
            const xhr = new XMLHttpRequest();
            xhr.open('POST', 'subject.php');
            xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');

            // Handle the response
            xhr.onload = () => {
                if (xhr.status === 200) {
                    alert('Subject updated successfully!');
                    window.location.reload(); // Reload the page to show updated data
                } else {
                    alert('Error updating subject. Please try again.');
                }
            };

            // Send data
            xhr.send(`subject_id=${subjectId}&subject_name=${encodeURIComponent(name)}&subject_code=${encodeURIComponent(code)}`);
        }
    </script>
</body>

</html>