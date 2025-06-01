<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sign UP</title>
    <link rel="icon" type="image/png" href="../assets/images/logotransp.png">
    <link rel="stylesheet" href="../assets/css/signup.css">
</head>
<body>

<?php
session_start();
require_once '../includes/dbconnect.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $fname = mysqli_real_escape_string($conn, $_POST['fname']);
    $lname = mysqli_real_escape_string($conn, $_POST['lname']);
    $contact = mysqli_real_escape_string($conn, $_POST['contact']);
    $email = mysqli_real_escape_string($conn, $_POST['email']);
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT);

    // Check if email already exists
    $check_email = "SELECT * FROM users WHERE email = '$email'";
    $result = $conn->query($check_email);
    
    if ($result->num_rows > 0) {
        echo "<script>alert('Email already exists!');</script>";
    } else {
        // Insert new user
        $sql = "INSERT INTO users (first_name, last_name, contact, email, password) 
                VALUES ('$fname', '$lname', '$contact', '$email', '$password')";
        
        if ($conn->query($sql) === TRUE) {
            echo "<script>alert('Registration successful! Please login.');
                  window.location.href='signin.php';</script>";
        } else {
            echo "<script>alert('Error: " . $conn->error . "');</script>";
        }
    }
}
?>

<div class="formbg">
    <div class="sideimg">
        <h3 class="here0">SIGN UP Here</h3>
        <h3 class="here11">If you already have an account...</h3>
        <p class="here22">click here to </p>
        <h3 class="here33"><a href="../pages/signin.php">sign in</a></h3>
    </div>
    <div class="formdiv">
        <form class="frm" action="signup.php" method="post">
            <label for="fname" class="fname">First Name</label><br>
            <input type="text" id="fname" name="fname" size="38" required><br><br>

            <label for="lname" class="lname">Last Name</label><br>
            <input type="text" id="lname" name="lname" size="38" required><br><br>

            <label for="contact" class="contact">Contact</label><br>
            <input type="text" id="contact" name="contact" size="38" required><br><br>

            <label for="email" class="email">Email</label><br>
            <input type="email" id="email" name="email" size="38" required><br><br>

            <label for="password" class="password">Password</label><br>
            <input type="password" id="password" name="password" size="38" required><br><br>

            <input type="submit" class="btn" value="Submit">
        </form>
    </div>  
</div>

<div class="home_container">
    <a href="../index.php"><button class="homebtn">Back to Home</button></a>
</div>

</body>
</html>
