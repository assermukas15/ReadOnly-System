<?php
// Include database connection setup
$mysqli = require __DIR__ . "/database.php";

// Validate and sanitize input
$name = isset($_POST["name"]) ? trim($_POST["name"]) : '';
$email = isset($_POST["email"]) ? trim($_POST["email"]) : '';

if (empty($name) || !preg_match("/^[a-zA-Z\s]+$/", $name)) {
    echo "<script>alert('Name is required and must contain only letters.');
          window.location.href = '../pages/users.php';
          </script>";
    die();
}

if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
    echo "<script>alert('Valid email is required');
          window.location.href = '../pages/users.php';
          </script>";
    die();
}

// Sanitize inputs
$name = $mysqli->real_escape_string($name);
$email = $mysqli->real_escape_string($email);

// Check if the email exists in the database
$sql = "SELECT * FROM user WHERE email = '$email'";
$result = $mysqli->query($sql);

if ($result && $result->num_rows > 0) {
    // Update the name for the user with the provided email
    $updateSql = "UPDATE user SET name = '$name' WHERE email = '$email'";
    if ($mysqli->query($updateSql)) {
        echo "<script>alert('User information updated successfully.');
              window.location.href = '../pages/users.php';
              </script>";
    } else {
        echo "Error updating record: " . $mysqli->error;
    }
} else {
    echo "<script>alert('User with this email does not exist.');
          window.location.href = '../pages/users.php';
          </script>";
}

$mysqli->close();
