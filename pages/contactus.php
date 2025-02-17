<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet"  href="../assets/css/nav.css">
    <link rel="stylesheet"  href="../assets/css/footer.css">
    <link rel="stylesheet"  href="../assets/css/contact.css">
    <link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.1/css/all.min.css">
    <title>Contact Us</title>
</head>
<body>

<?php
  include('../partials/navbar.php');
?>
<div class="container">
    <div class="box">
        <div class="list">
            <ul class="list_i">
                <li>Adress</li>
                <li>Contact</li>
                <li>email</li>
            </ul>
        </div>
    </div>
    <div class="formdiv">
        <form action="#" method="post">
            <label for="fname">Name:</label><br>
            <input type="text" id="fname" name="fname" required><br><br>

            <label for="email">Email Address:</label><br>
            <input type="email" id="email" name="email" required><br><br>

            <label for="message">Message:</label><br>
            <textarea id="message" name="message" rows="4" cols="50" required></textarea><br><br>

            <input type="submit" value="Submit">
        </form>
    </div>
</div>



<?php
    include('../partials/footer.php');
?>
    
</body>
</html>