<?php 
session_start();
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="stylesheet" href="../manuallk/assets/css/nav.css">
  <link rel="stylesheet" href="../manuallk/assets/css/footer.css">
  <link rel="stylesheet" href="../manuallk/assets/css/index.css">
  <link rel="stylesheet" href="../manuallk/assets/css/about.css">
  <link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.1/css/all.min.css">
  <title>ManualLK</title>
  <link rel="icon" type="image/png" href="../manuallk/assets/images/logotransp.png">
</head>
<body>
<header>
    <div class="navbar">
        <div class="logo">
            <img src="assets\images\logotransp.png" alt="Logo">
            <p>ManualLK</p>
        </div>
        <ul class="nav-links">
            <li><a href="../index.php">Home</a></li>
            <li><a href="pages\find.php">Find</a></li>
            <li><a href="pages\aboutus.php">About</a></li>
            <?php if (!isset($_SESSION['user_id'])): ?>
                <li><a href="pages\signin.php">Contact</a></li>
            <?php endif; ?>
            <?php if (isset($_SESSION['user_id'])): ?>
                <li><a href="pages\contactus.php">Contact</a></li>
                <li><a href="./pages/logout.php">Logout</a></li>
            <?php endif; ?>

        </ul>
    </div>
</header>

  <div class="containerwelcome">
    <div class="box">
      <div class="glaz">
        <p>Welcome Home</p>
        <a href="pages/start.php"><button class="start-btn">Start Here</button></a>
      </div>
    </div>
  </div>

  <div class="wel_container">
    <div class="welcome">
      Welcome to ManualLK<br>
      Sri Lanka's largest vehicle marketplace. Whether you're looking to buy or sell, we offer a wide range of vehicles at affordable prices.<br>
      Our platform connects buyers and sellers seamlessly, ensuring a hassle-free experience. Start your journey today and find the perfect vehicle to match your needs.
    </div>
  </div>

  <div class="vehilogo_container">
        <div class="cardlogo">
          <img src="../manuallk/assets/images/toyota.jpg" alt="Avatar" style="width: 100%">
        </div>
        <div class="cardlogo">
          <img src="../manuallk/assets/images/bense.jpg" alt="Avatar" style="width: 100%">
        </div>
        <div class="cardlogo">
          <img src="../manuallk/assets/images/bmw.jpg" alt="Avatar" style="width: 100%">
       </div> 
         <div class="cardlogo">
          <img src="../manuallk/assets/images/nissan.jpg" alt="Avatar" style="width: 100%">
        </div>
        <div class="cardlogo">
          <img src="../manuallk/assets/images/suzuki.jpg" alt="Avatar" style="width: 100%"> 
         </div>
         <div class="cardlogo">
          <img src="../manuallk/assets/images/honda.jpg" alt="Avatar" style="width: 100%">
        </div>
        <div class="cardlogo">
          <img src="../manuallk/assets/images/ISUZU-logo.jpg" alt="Avatar" style="width: 100%">
        </div>   
  </div>

  <div class="os_container">
    <div class="osb">
      <a href="pages/find.php"><button class="buy">Buy your vehicle</button></a>
    </div>
    <div class="oss">
      <a href="../manuallk/pages/signin.php"><button class="sell">Sell your vehicle</button></a>
    </div>
  </div>

  <div class="crd_con">
    <h3 class="card_heading">Sri Lankan's Most Popular</h3>
    <div class="card_container">
      <div class="card">
        <img src="../manuallk/assets/images/ct100.png" alt="Avatar" style="width: 100%">
        <div class="container">
          <h4><b>CT100</b></h4>
          <p>Bajaj 100cc</p>
        </div>
      </div>
      <div class="card">
        <img src="../manuallk/assets/images/3weel.png" alt="Avatar" style="width: 100%">
        <div class="container">
          <h4><b>Three Wheeler</b></h4>
          <p>Bajaj re205</p>
        </div>
      </div>
      <div class="card">
        <img src="../manuallk/assets/images/alto.png" alt="Avatar" style="width: 100%">
        <div class="container">
          <h4><b>Alto</b></h4>
          <p>Suzuki 800cc</p>
        </div>
      </div>
      <div class="card">
        <img src="../manuallk/assets/images/kdh.png" alt="Avatar" style="width: 100%">
        <div class="container">
          <h4><b>KDH</b></h4>
          <p>Toyota 2500cc</p>
        </div>
      </div>
    </div>
  </div>

  <div class="box2">
    <div class="abcrd">
      <h3>About Us</h3><br>
      <p>Welcome to ManualLK, your trusted platform for buying and selling vehicles. Our mission is to connect buyers and sellers, providing a seamless and secure experience for all users. Whether you are looking for a brand-new car, a pre-owned vehicle, or want to sell your own, we make the process simple and efficient.<br>
        With a user-friendly interface and advanced search options, we ensure that you find the perfect vehicle that fits your needs and budget. Our team is committed to maintaining transparency, security, and customer satisfaction. Join us today and experience hassle-free vehicle trading like never before!</p>
    </div>
    <div class="cardai">
      <img src="../manuallk/assets/images/ai.jpg" alt="Avatar" style="width: 100%">
      <div class="container">
        <h4><b>Awishka Isuru</b></h4>
        <p>Full Stack Developer</p><br>
        0701224436
        <a href="mailto:awishkaisuru0573@gmail.com">awishkaisuru0573@gmail.com</a>
      </div>
    </div>
  </div>

  <?php include('../manuallk/partials/footer.php'); ?>

  <script>
    document.documentElement.style.scrollBehavior = "smooth";
  </script>
</body>
</html>
