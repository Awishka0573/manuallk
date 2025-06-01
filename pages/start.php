<?php
session_start();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Find</title>
    <link rel="stylesheet"  href="../assets/css/start.css">
    <link rel="icon" type="image/png" href="../assets/images/logotransp.png">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">

</head>
<body>

<div class="home_container2">
    <p class="des_sell">post your add here</p>
    <a href="../pages/signin.php"><button class="homebtn2">sell your vehicle</button></a>
</div>

<div class="container">
    <div class="search-container text-center">
        <h3 class="mb-4"><b>Find The Best Vehicle For You</b></h3>
        <form action="search.php" method="GET">
            <div class="row g-3">
                <div class="col-md-4">
                    <select name="make" class="form-control">
                        <option value="">Any Make</option>
                        <option value="Toyota">Toyota</option>
                        <option value="Honda">Honda</option>
                        <option value="Ford">Ford</option>
                    </select>
                </div>
                <div class="col-md-4">
                    <input type="text" name="model" class="form-control" placeholder="Model (e.g., Corolla)">
                </div>
                <div class="col-md-4">
                    <select name="type" class="form-control">
                        <option value="">Any Type</option>
                        <option value="SUV">SUV</option>
                        <option value="Sedan">Sedan</option>
                        <option value="Truck">Truck</option>
                    </select>
                </div>
                <div class="col-md-4">
                    <select name="condition" class="form-control">
                        <option value="">Any Condition</option>
                        <option value="New">New</option>
                        <option value="Used">Used</option>
                    </select>
                </div>
                <div class="col-md-4">
                    <select name="price" class="form-control">
                        <option value="">Any Price Range</option>
                        <option value="0-10000">$0 - $10,000</option>
                        <option value="10000-20000">$10,000 - $20,000</option>
                    </select>
                </div>
                <div class="col-md-4">
                    <select name="city" class="form-control">
                        <option value="">Any City</option>
                        <option value="New York">New York</option>
                        <option value="Los Angeles">Los Angeles</option>
                    </select>
                </div>
                <div class="col-md-12">
                    <button type="submit" class="search-btn">Search</button>
                </div>
            </div>
        </form>
    </div>
</div>

<div class="home_container1">
    <a href="../index.php"><button class="homebtn1">Back to Home</button></a>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>