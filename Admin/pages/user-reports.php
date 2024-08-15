<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width,initial-scale=1.0">
    <title>USERS REPORTS</title>

    <!-- Montserrat Font -->
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@100;200;300;400;500;600;700;800;900&display=swap" rel="stylesheet">

    <!-- Material Icons -->
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons+Outlined" rel="stylesheet">

    <!-- Custom CSS -->

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/5.3.0/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/2.0.8/css/dataTables.bootstrap5.css">
    <link rel="stylesheet" href="../css/all-reports.css">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.9.4/Chart.js"></script>


</head>

<body>
    <main class="main-container">
        <h4>User activity</h4>



        <div class="main-cards">


            <!-- MAIN CARDS -->

            <?php
            // DATABASE CONNECTION
            $mysqli = require __DIR__ . "/database.php";

            // Get the current time and the time 24 hours ago
            $current_time = date('Y-m-d H:i:s');
            $time_24_hours_ago = date('Y-m-d H:i:s', strtotime('-24 hours'));

            // SQL query to count total number of users
            $sql_total_users = 'SELECT COUNT(*) as count FROM user';
            $result_total_users = $mysqli->query($sql_total_users);
            $total_users = 0;

            if ($result_total_users->num_rows > 0) {
                $row = $result_total_users->fetch_assoc();
                $total_users = $row['count'];
            } else {
                echo '<h1>Error executing query: ' . $mysqli->error . '</h1>';
            }

            // SQL query to count users active in the last 24 hours
            $sql_active_users = "SELECT COUNT(*) as active_user_count FROM user WHERE last_active >= '$time_24_hours_ago'";
            $result_active_users = $mysqli->query($sql_active_users);
            $active_users = 0;

            if ($result_active_users) {
                $row = $result_active_users->fetch_assoc();
                $active_users = $row['active_user_count'];
            } else {
                echo '<h1>Error executing query: ' . $mysqli->error . '</h1>';
            }

            // SQL query to count users registered in the last 24 hours
            $sql_recent_users = "SELECT COUNT(*) as recent_user_count FROM user WHERE registered_at >= '$time_24_hours_ago'";
            $result_recent_users = $mysqli->query($sql_recent_users);
            $recent_users = 0;

            if ($result_recent_users) {
                $row = $result_recent_users->fetch_assoc();
                $recent_users = $row['recent_user_count'];
            } else {
                echo '<h1>Error executing query: ' . $mysqli->error . '</h1>';
            }

            // Calculate inactive users
            $inactive_users = $total_users - $active_users;

            // Close connection
            $mysqli->close();
            ?>

            <div class="card">
                <div class="card-inner">
                    <h3>USERS</h3>
                    <span class="material-icons-outlined">groups</span>
                </div>
                <h1><?php echo $total_users; ?></h1>
            </div>

            <div class="card">
                <div class="card-inner">
                    <h3>ACTIVE LAST 24H</h3>
                    <span class="material-icons-outlined">person_check</span>
                </div>
                <h1><?php echo $active_users; ?></h1>
            </div>

            <div class="card">
                <div class="card-inner">
                    <h3>INACTIVE USERS</h3>
                    <span class="material-icons-outlined">person_off</span>
                </div>
                <h1><?php echo $inactive_users; ?></h1>
            </div>

            <div class="card">
                <div class="card-inner">
                    <h3>RECENTLY REGISTERED</h3>
                    <span class="material-icons-outlined">person_add</span>
                </div>
                <h1><?php echo $recent_users; ?></h1>
            </div>

        </div>



        <table id="example" class="table table-striped" style="width:100%">
            <thead>
                <tr>
                    <th>Name</th>
                    <th>Email</th>
                    <th>Last Active</th>
                    <th>Registered At</th>
                    <th>Active Last 24H</th>
                    <th>Active</th>
                </tr>
            </thead>
            <tbody>
                <?php
                $mysqli = require __DIR__ . "/database.php";

                // Get the current time and the time 24 hours ago
                $current_time = date('Y-m-d H:i:s');
                $time_24_hours_ago = date('Y-m-d H:i:s', strtotime('-24 hours'));

                // SQL query to select required columns and add computed columns for activity status
                $sql = "
            SELECT 
                name, 
                email, 
                last_active, 
                registered_at,
                CASE 
                    WHEN last_active >= '$time_24_hours_ago' THEN 'YES' 
                    ELSE 'NO' 
                END AS active_last_24h,
                CASE 
                    WHEN last_active IS NOT NULL THEN 'YES' 
                    ELSE 'NO' 
                END AS active
            FROM user
        ";
                $result = $mysqli->query($sql);

                while ($row = $result->fetch_assoc()) {
                ?>
                    <tr>
                        <td><?php echo htmlspecialchars($row['name']); ?></td>
                        <td><?php echo htmlspecialchars($row['email']); ?></td>
                        <td><?php echo htmlspecialchars($row['last_active']); ?></td>
                        <td><?php echo htmlspecialchars($row['registered_at']); ?></td>
                        <td><?php echo htmlspecialchars($row['active_last_24h']); ?></td>
                        <td><?php echo htmlspecialchars($row['active']); ?></td>
                    </tr>
                <?php
                }

                // Close connection
                $mysqli->close();
                ?>
            </tbody>
            <tfoot>
                <tr>
                    <th>Name</th>
                    <th>Email</th>
                    <th>Last Active</th>
                    <th>Registered At</th>
                    <th>Active Last 24H</th>
                    <th>Active</th>
                </tr>
            </tfoot>
        </table>










    </main>





    <script src="https://code.jquery.com/jquery-3.5.1.js"></script>
    <script src="https://cdn.datatables.net/1.13.1/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.1/js/dataTables.bootstrap5.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <script src="../js/scripts.js"></script>

</body>

</html>