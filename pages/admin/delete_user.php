<?php
session_start();
require_once '../../includes/dbconnect.php';

if (isset($_GET['id'])) {
    $user_id = mysqli_real_escape_string($conn, $_GET['id']);
    
    // Delete user from database
    $sql = "DELETE FROM users WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $user_id);
    
    if ($stmt->execute()) {
        // Deletion successful
        header("Location: index.php?msg=deleted");
        exit();
    } else {
        // Deletion failed
        header("Location: index.php?msg=error");
        exit();
    }
} else {
    // No ID provided
    header("Location: index.php");
    exit();
}
?>