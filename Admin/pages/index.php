<?php

session_start();

if (isset($_SESSION["user_id"])) {

  $mysqli = require __DIR__ . "/database.php";

  $sql = "SELECT * FROM administrator WHERE id = {$_SESSION["user_id"]}";

  $result = $mysqli->query($sql);

  $user = $result->fetch_assoc();
}

?>



<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width,initial-scale=1.0">
  <title>Admin Dashboard</title>

  <!-- Montserrat Font -->
  <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@100;200;300;400;500;600;700;800;900&display=swap" rel="stylesheet">

  <!-- Material Icons -->
  <link href="https://fonts.googleapis.com/icon?family=Material+Icons+Outlined" rel="stylesheet">

  <!-- Custom CSS -->
  <link rel="stylesheet" href="../css/styles.css">
</head>

<?php if (isset($user)) : ?>

  <body>
    <div class="grid-container">

      <!-- Header -->
      <header class="header">
        <div class="menu-icon" onclick="openSidebar()">
          <span class="material-icons-outlined">menu</span>
        </div>
        <div class="header-right">
          <h4>Hello, &nbsp; <?= htmlspecialchars($user["name"]) ?>&nbsp;&nbsp;<a href="../scripts/logout.php"> log out</a></h4>
        </div>
      </header>
      <!-- End Header -->

      <!-- Sidebar -->
      <aside id="sidebar">
        <div class="sidebar-title">
          <div class="sidebar-brand">
            <span class="material-icons-outlined"></span>READ ONLY System
          </div>
          <span class="material-icons-outlined" onclick="closeSidebar()">close</span>
        </div>

        <ul class="sidebar-list">
          <li class="sidebar-list-item">
            <a href="./index.php">
              <span class="material-icons-outlined">dashboard</span>&nbsp; Dashboard
            </a>
          </li>
          <li class="sidebar-list-ite">
            <p>
              <span class="material-icons-outlined"></span><b>&nbsp;| Management |</b>
            </p>
          </li>
          <li class="sidebar-list-item">
            <a href="./books.php">
              <span class="material-icons-outlined">menu_book</span>&nbsp; Books
            </a>
          </li>
          <li class="sidebar-list-item">
            <a href="./users.php">
              <span class="material-icons-outlined">groups</span>&nbsp; Users
            </a>
          </li>
          <li class="sidebar-list-item">
            <a href="./admins.php">
              <span class="material-icons-outlined">admin_panel_settings</span>&nbsp; Admins
            </a>
          </li>
          <li class="sidebar-list-item">
            <a href="./reports.php">
              <span class="material-icons-outlined">poll</span>&nbsp; Reports
            </a>
          </li>
          <!--
          <li class="sidebar-list-item">
            <a href="#" target="_blank">
              <span class="material-icons-outlined">settings</span>&nbsp; Settings
            </a>
          </li>
          -->
        </ul>
      </aside>

      <!-- End Sidebar -->

      <!-- Main -->
      <main class="main-container">
        <div class="main-title">
          <h2>DASHBOARD</h2>
        </div>

        <div class="main-cards">

          <div class="card">
            <div class="card-inner">
              <h3>USERS</h3>
              <span class="material-icons-outlined">groups</span>
            </div>
            <?php
            // COUNT AND DISPLAY NUMBER OF USERS
            $mysqli = require __DIR__ . "/database.php";

            $sql = 'SELECT COUNT(*) as count FROM user';
            $result = $mysqli->query($sql);

            if ($result->num_rows > 0) {
              $row = $result->fetch_assoc();
              echo '<h1>' . $row['count'] . '</h1>';
            } else {
              die();
            }
            ?>
          </div>

          <div class="card">
            <div class="card-inner">
              <h3>ADMINISTRATORS</h3>
              <span class="material-icons-outlined">admin_panel_settings</span>
            </div>
            <?php
            // COUNT AND DISPLAY NUMBER OF ADMINS
            $mysqli = require __DIR__ . "/database.php";

            $sql = 'SELECT COUNT(*) as count FROM administrator';
            $result = $mysqli->query($sql);

            if ($result->num_rows > 0) {
              $row = $result->fetch_assoc();
              echo '<h1>' . $row['count'] . '</h1>';
            } else {
              die();
            }
            ?>
          </div>

          <div class="card">
            <div class="card-inner">
              <h3>BOOKS</h3>
              <span class="material-icons-outlined">book_2</span>
            </div>
            <?php
            // COUNT AND DISPLAY NUMBER OF BOOKS AVAILABLE
            $mysqli = require __DIR__ . "/database.php";

            $sql = 'SELECT COUNT(*) as count FROM book';
            $result = $mysqli->query($sql);

            if ($result->num_rows > 0) {
              $row = $result->fetch_assoc();
              echo '<h1>' . $row['count'] . '</h1>';
            } else {
              die();
            }
            ?>
          </div>

          <div class="card">
            <div class="card-inner">
              <h3>ACTIVE LAST 24H</h3>
              <span class="material-icons-outlined">person_check</span>
            </div>
            <?php
            // DATABASE CONNECTION
            $mysqli = require __DIR__ . "/database.php";

            // Get the current time and the time 24 hours ago
            $current_time = date('Y-m-d H:i:s');
            $time_24_hours_ago = date('Y-m-d H:i:s', strtotime('-24 hours'));

            // SQL query to count users active in the last 24 hours
            $sql = "SELECT COUNT(*) as active_user_count FROM user WHERE last_active >= '$time_24_hours_ago'";

            $result = $mysqli->query($sql);

            if ($result) {
              $row = $result->fetch_assoc();
              echo "<h1>" . $row['active_user_count'] . "</h1>";
            } else {
              echo "<h1>Error executing query: " . $mysqli->error . "</h1>";
            }

            // Close connection
            $mysqli->close();
            ?>
          </div>

        </div>

      </main>
      <!-- End Main -->

    </div>




    <!-- Scripts -->
    <!-- ApexCharts -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/apexcharts/3.35.5/apexcharts.min.js"></script>
    <!-- Custom JS -->
    <script src="../js/scripts.js"></script>



  <?php else : ?>
    echo "<script>
      alert('Please register')
      window.location.href = '../index.html'
    </script>";
  <?php endif; ?>

  </body>

</html>