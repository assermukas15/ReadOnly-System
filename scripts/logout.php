<?php
session_start();

//Comment
// Check if user is logged in
if (isset($_SESSION["user_id"])) {
    // DATABASE CONNECTION
    $mysqli = require __DIR__ . "/database.php";

    $user_id = $_SESSION["user_id"];

    // Update last_active column
    $current_time = date('Y-m-d H:i:s');
    $update_sql = "UPDATE user SET last_active = '$current_time' WHERE id = $user_id";
    $mysqli->query($update_sql);
}

// Destroy session
session_destroy();

echo "<script> alert('You have been logged out');
                window.location.href = '../pages/login-register.html';
                </script>";
exit;
