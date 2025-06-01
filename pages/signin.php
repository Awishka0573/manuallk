<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sign IN</title>
    <link rel="icon" type="image/png" href="../assets/images/logotransp.png">
    <link rel="stylesheet" href="../assets/css/signin.css">
</head>
<body>

<?php
session_start();
require_once '../includes/dbconnect.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = mysqli_real_escape_string($conn, $_POST['email']);
    $password = $_POST['password'];

    $sql = "SELECT * FROM users WHERE email = '$email'";
    $result = $conn->query($sql);

    if ($result->num_rows == 1) {
        $user = $result->fetch_assoc();
        if (password_verify($password, $user['password'])) {
            $_SESSION['user_id'] = $user['id'];
            $_SESSION['email'] = $user['email'];
            $_SESSION['first_name'] = $user['first_name'];
            
            echo "<script>alert('Login successful!');
                  window.location.href='../index.php';</script>";
        } else {
            echo "<script>alert('Invalid password!');</script>";
        }
    } else {
        echo "<script>alert('User not found!');</script>";
    }
}
?>

<div class="formbg">
    <div class="formdiv">
        <form class="frm" action="signin.php" method="post">
            <label for="email" class="email">Email</label><br>
            <input type="email" id="email" name="email" size="38" required><br><br>

            <label for="password" class="password">Password</label><br>
            <input type="password" id="password" name="password" size="38" required><br><br>

            <input type="submit" class="btn" value="Submit">
        </form>
    </div>
    <div class="sideimg">
        <h3 class="here">SIGN IN Here</h3>
        <h3 class="here1">If you already have an account...</h3>
        <p class="here2">click here to register</p>
        <h3 class="here3"><a href="../pages/signup.php">sign up</a></h3>
    </div>   
</div>

<div class="home_container">
    <a href="../index.php"><button class="homebtn">Back to Home</button></a>
</div>

</body>
</html>
