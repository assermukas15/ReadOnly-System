<?php

// TOKEN CHEKING IF EXPIRED OR NOT

$token = $_POST["token"];

$token_hash = hash("sha256", $token);

$mysqli = require __DIR__ . "/database.php";

$sql = "SELECT * FROM user WHERE reset_token_hash = ?";

$stmt = $mysqli->prepare($sql);

$stmt->bind_param("s", $token_hash);

$stmt->execute();

$result = $stmt->get_result();

$user = $result->fetch_assoc();

if ($user === null)
{
    die("Token not found");
}

if (strtotime($user["reset_token_expires_at"]) <= time())
{
    die("Token has expired");
}

// SERVER SIDE VALIDATION AND PASSWORD CONFIRMATION

if (strlen($_POST["password"]) < 8) {
    die("Password must contain at least 8 characters");
}

if (!preg_match("/[a-z]/i", $_POST["password"])) {
    die("Password must contain at least one letter");
}

if (!preg_match("/[0-9]/", $_POST["password"])) {
    die("Password must contain at least one number");
}

if ($_POST["password"] !== $_POST["password_confirmation"]) {
    die("Password must match");
}

// HASH PASSWORD
$password_hash = password_hash($_POST["password"], PASSWORD_DEFAULT);

// UPDATING THE PASSWORD

$sql = "UPDATE user SET password_hash = ?, reset_token_hash = NULL, reset_token_expires_at = NULL WHERE id = ?";

$stmt = $mysqli->prepare($sql);

$stmt->bind_param("ss", $password_hash, $user["id"]);

$stmt->execute();

echo "<script> alert('Password updated. Now you can login.')
                window.location.href = '../pages/login-register.html'
                </script>";
