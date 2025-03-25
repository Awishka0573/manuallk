<?php
$host = "localhost:3307";
$user = "root";
$pass = "";
$dbname = "manuallk"; // Database name eka danna

$conn = new mysqli($host, $user, $pass, $dbname);

// Connection check
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
?>