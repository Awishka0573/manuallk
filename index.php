<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="stylesheet"  href="../manuallk/assets/css/nav.css">
  <link rel="stylesheet"  href="../manuallk/assets/css/footer.css">
  <link rel="stylesheet"  href="../manuallk/assets/css/index.css">
  <link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.1/css/all.min.css">
  <title>ManualLK</title>
  <link rel="icon" type="image/png" href="../manuallk/assets/images/logotransp.png">
</head>
<body>
  
  <?php
  include('../manuallk/partials/navbar.php');
  ?>

  <div class="containerwelcome">
    <div class="box">
      <div class="glaz">
      <p>Welcome Home</p>
      <button class="start-btn">Start Here</button>
    </div>
    </div>
  </div>
  <div class="wel_container">
    <div class="welcome">
      Welcome to ManualLK<br> 
      Sri Lanka's largest vehicle marketplace. Whether you're looking to buy or sell, we offer a wide range of vehicles at affordable prices.<br>
      Our platform connects buyers and sellers seamlessly, ensuring a hassle-free experience. Start your journey today and find the perfect vehicle to match your needs.    </div>
  </div>

  <div class="os_container">
    <div class="osb"> 
      <button class="buy">Buy your vehicle</button>
    </div>
    <div class="oss">
      <button class="sell">Sell your vehicle</button> 
    </div>
  </div>

  <div class="card_container">
  <div class="card">
      <img src="../manuallk/assets/images//ct.jpg" alt="Avatar" style="width: 100%">
      <div class="container">
        <h4><b>CT100</b></h4>
        <p>Bajaj 100cc</p>
      </div>
    </div>
    <div class="card">
      <img src="../manuallk/assets/images/threeweel.png" alt="Avatar" style="width: 100%">
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

  
  <?php
    include('../manuallk/partials/footer.php');
  ?>
  
  <script>
    document.documentElement.style.scrollBehavior = "smooth";
  </script>
</body>
</html>