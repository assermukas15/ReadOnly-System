<?php
// SERVER SIDE VALIDATION AND PASSWORD CONFIRMATION
if (empty($_POST["name"]) || !preg_match("/^[a-zA-Z\s]+$/", $_POST["name"])) {
    echo "<script> alert('Name is required and must contain only letters.');
                window.location.href = '../pages/users.php';
                </script>";
    die();
}


if (!filter_var($_POST["email"], FILTER_VALIDATE_EMAIL)) {
    echo "<script> alert('Valid email is required')
                window.location.href = '../pages/users.php'
                </script>";
    die();
}

if (strlen($_POST["password"]) < 8) {
    echo "<script> alert('Password must contain at least 8 characters')
                window.location.href = '../pages/users.php'
                </script>";
    die();
}

if (!preg_match("/[a-z]/i", $_POST["password"])) {
    echo "<script> alert('Password must contain at least one letter')
                window.location.href = '../pages/users.php'
                </script>";
    die();
}

if (!preg_match("/[0-9]/", $_POST["password"])) {
    echo "<script> alert('Password must contain at least one number')
                window.location.href = '../pages/users.php'
                </script>";
    die();
}

if ($_POST["password"] !== $_POST["password_confirmation"]) {
    echo "<script> alert('Password must match')
                window.location.href = '../pages/users.php'
                </script>";
    die();
}

// HASH PASSWORD
$password_hash = password_hash($_POST["password"], PASSWORD_DEFAULT);

// DATABASE CONNECTION

$mysqli = require __DIR__ . "/database.php";

// Check if email is already taken
$sql = sprintf("SELECT * FROM user WHERE email = '%s'", $mysqli->real_escape_string($_POST["email"]));
$result = $mysqli->query($sql);
$is_available = $result->num_rows === 0;

if (!$is_available) {
    // Email is already taken
    echo "<script> alert('Email is already taken')
                window.location.href = '../pages/users.php'
                </script>";
    die();
} else {
    // Email is available, proceed with registration
    // INSERT INTO DATABASE
    $sql = "INSERT INTO user (name, email, password_hash) VALUES (?, ?, ?)";
    $stmt = $mysqli->prepare($sql);

    if (!$stmt) {
        die("SQL error: " . $mysqli->error);
    }

    // Assuming $password_hash is defined earlier
    $stmt->bind_param("sss", $_POST["name"], $_POST["email"], $password_hash);

    if ($stmt->execute()) {
        // Registration successful
        echo "<script> alert('Registration successful.')
                window.location.href = '../pages/users.php'
                </script>";
    } else {
        // Error occurred during registration
        echo "<script> alert('Registration failed. Please try again')
                window.location.href = '../pages/users.php'
                </script>";
        die();
    }

    $stmt->close();
}

$mysqli->close();
