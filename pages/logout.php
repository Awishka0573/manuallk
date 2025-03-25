<?php
session_start();
session_destroy(); // Session clear karanawa
header("Location: signin.php"); // Login page ekata redirect
exit();
?>