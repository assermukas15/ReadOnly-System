<?php
// delete_admin.php

$mysqli = require __DIR__ . "/database.php";

if ($mysqli->connect_error) {
  die("Connection failed: " . $mysqli->connect_error);
}

if ($_SERVER['REQUEST_METHOD'] === 'DELETE') {
  // Assuming 'email' is sent as a query parameter
  $adminEmail = $_GET['email'];

  $sql = "DELETE FROM administrator WHERE email = ?";
  $stmt = $mysqli->prepare($sql);
  $stmt->bind_param("s", $adminEmail);

  if ($stmt->execute()) {
    // Return success response
    echo "<script>window.location.href = '../pages/admins.php';
          </script>";
    exit();
  } else {
    // Return error response
    echo "<script>alert('Error');
          window.location.href = '../pages/admins.php';
          </script>";
    exit();
  }
}
