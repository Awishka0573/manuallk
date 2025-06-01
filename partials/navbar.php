<?php
session_start();
?>


<header>
    <div class="navbar">
        <div class="logo">
            <img src="assets\images\logotransp.png" alt="Logo">
            <p>ManualLK</p>
        </div>
        <ul class="nav-links">
            <li><a href="../index.php">Home</a></li>
            <li><a href="./find.php">Find</a></li>
            <li><a href="./aboutus.php">About</a></li>
            <?php if (!isset($_SESSION['user_id'])): ?>
                <li><a href="./signin.php">Contact</a></li>
            <?php endif; ?>
            <?php if (isset($_SESSION['user_id'])): ?>
                <li><a href="./contactus.php">Contact</a></li>
                <li><a href="./logout.php">Logout</a></li>
            <?php endif; ?>

        </ul>
    </div>
</header>