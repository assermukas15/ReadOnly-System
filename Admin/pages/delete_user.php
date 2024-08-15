<?php
// delete_user.php

$mysqli = require __DIR__ . "/database.php";

if ($mysqli->connect_error) {
  die("Connection failed: " . $mysqli->connect_error);
}

if ($_SERVER['REQUEST_METHOD'] === 'DELETE') {
  // Assuming 'email' is sent as a query parameter
  $userEmail = $_GET['email'];

  $sql = "DELETE FROM user WHERE email = ?";
  $stmt = $mysqli->prepare($sql);
  $stmt->bind_param("s", $userEmail);

  if ($stmt->execute()) {
    // Return success response
    echo "<script>window.location.href = './pages/users.php';
          </script>";
    exit();
  } else {
    echo "<script>alert('Error');
          window.location.href = './pages/users.php';
          </script>";
    exit();
  }
}
