<?php
session_start();
include('../includes/dbconnect.php');

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = mysqli_real_escape_string($conn, $_POST['fname']);
    $email = mysqli_real_escape_string($conn, $_POST['email']);
    $message = mysqli_real_escape_string($conn, $_POST['message']);
    
    // Get user_id from session if user is logged in
    $user_id = isset($_SESSION['user_id']) ? $_SESSION['user_id'] : NULL;
    
    $sql = "INSERT INTO feedback (user_id, name, email, message) VALUES (?, ?, ?, ?)";
    $stmt = mysqli_prepare($conn, $sql);
    mysqli_stmt_bind_param($stmt, "isss", $user_id, $name, $email, $message);
    
    if (mysqli_stmt_execute($stmt)) {
        echo "<script>alert('Thank you for your feedback!');</script>";
    } else {
        echo "<script>alert('Error: Unable to submit feedback.');</script>";
    }
    
    mysqli_stmt_close($stmt);
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet"  href="../assets/css/nav.css">
    <link rel="stylesheet"  href="../assets/css/footer.css">
    <link rel="stylesheet"  href="../assets/css/contact.css">
    <link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.1/css/all.min.css">
    <link rel="icon" type="image/png" href="../assets/images/logotransp.png">

    <title>Contact Us</title>
</head>
<body>

<?php
  include('../partials/navbar.php');
?>
<div class="container1">
    <div class="box1">
        <div class="adress">
            <img src="../assets/images/adress.png" alt="">
        <h3>Adress</h3>
            <p>No.01,Bandaranayaka mw, Ballapana Galigamuwa Town.</p>
        </div>
        <div class="contact">
            <img src="../assets/images/contacticon.png" alt="">
        <h3>Contact</h3>
            <p>0701224436</p>
        </div>
        <div class="email1">
            <img src="../assets/images/mail.png" alt="">
            <h3>Email</h3>
            <a href="mailto:awishkaisuru0573@gmail.com">awishkaisuru0573@gmail.com</a>
        </div>
    </div>
    <div class="formdiv">
        <form class="frm" action="#" method="post">
            <label for="fname" class="name">Name:</label><br>
            <input type="text" id="fname" name="fname" size="50" value="<?php echo isset($_SESSION['name']) ? htmlspecialchars($_SESSION['name']) : ''; ?>" readonly><br><br>


            <label for="email" class="email">Email Address:</label><br>
            <input type="email" id="email" name="email" size="50" value="<?php echo isset($_SESSION['email']) ? htmlspecialchars($_SESSION['email']) : ''; ?>" readonly><br><br>

            <label for="message" class="msg">Message:</label><br>
            <textarea id="message" name="message" rows="4" cols="50" required></textarea><br><br>

            <input type="submit" class="btn" value="Submit">
        </form>
    </div>
</div>



<?php
    include('../partials/footer.php');
?>
    
</body>
</html>