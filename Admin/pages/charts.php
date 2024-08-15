<?php
$mysqli = require __DIR__ . "/database.php";

// Get the current date and the date 5 months ago
$current_date = date('Y-m-d');
$date_5_months_ago = date('Y-m-d', strtotime('-5 months'));

// SQL query to count registrations per month
$sql = "
    SELECT 
        DATE_FORMAT(registered_at, '%Y-%m') AS month, 
        COUNT(*) AS registrations 
    FROM user 
    WHERE registered_at BETWEEN '$date_5_months_ago' AND '$current_date'
    GROUP BY month
    ORDER BY month
";
$result = $mysqli->query($sql);

$data = [];
while ($row = $result->fetch_assoc()) {
    $data[] = $row;
}

// Close connection
$mysqli->close();

// Return data as JSON
echo json_encode($data);
