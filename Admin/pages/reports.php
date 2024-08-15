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
    <title>REPORTS</title>

    <!-- Montserrat Font -->
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@100;200;300;400;500;600;700;800;900&display=swap" rel="stylesheet">

    <!-- Material Icons -->
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons+Outlined" rel="stylesheet">

    <!-- Custom CSS -->

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/5.3.0/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/2.0.8/css/dataTables.bootstrap5.css">
    <link rel="stylesheet" href="../css/reports.css">


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
                    <h6>Hello, &nbsp; <?= htmlspecialchars($user["name"]) ?>&nbsp;&nbsp;<a href="../scripts/logout.php"> log out</a></h6>
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
            <main class="main-container" style="background-color: rgb(255, 255, 255); ">

                <div class="container">

                    <div class="btn-group">
                        <a href="./user-reports.php" target="iframe" class="btn btn-outline-danger fw-bold" aria-current="page">USERS REPORTS</a>
                        <a href="#" target="blank" class="btn btn-outline-danger fw-bold">BOOKS REPORTS</a>

                    </div>
                </div>


                <div class="ratio ratio-16x9" style="margin-top: 15px;">
                    <iframe src="" title="W3Schools Free Online Web Tutorials" name="iframe"></iframe>
                </div>




            </main>
            <!-- End Main -->

        </div>

        <!-- Scripts -->
        <script src="../js/scripts.js"></script>




    <?php else : ?>
        echo "<script>
            alert('Please register')
            window.location.href = '../index.html'
        </script>";
    <?php endif; ?>

    </body>

</html>