<?php
session_start();
include '../includes/dbconnect.php'; // Database connection file

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = $_POST['email'];
    $password = $_POST['password'];

    // Prepare statement to avoid SQL injection
    $sql = "SELECT * FROM users WHERE email=?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows == 1) {
        $row = $result->fetch_assoc();
        
        // Verify password
        if (password_verify($password, $row['password'])) {
            $_SESSION['user_id'] = $row['id'];
            header("Location: ../pages/find.php");
            exit(); // Stop further script execution
        } else {
            echo "<script>alert('Incorrect password!');</script>";
        }
    } else {
        echo "<script>alert('No user found with that email address.');</script>";
    }
}
?>

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
