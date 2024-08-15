<?php
// DATABASE CONNECTION
$mysqli = require __DIR__ . "/database.php";

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $emaillog = $mysqli->real_escape_string($_POST["emaillog"]);

    $sql = "SELECT * FROM administrator WHERE email = '$emaillog'";

    $result = $mysqli->query($sql);

    if ($result) {
        $user = $result->fetch_assoc(); 

        if ($user) {
            if (password_verify($_POST["passwordlog"], $user["password_hash"])) {
                
                session_start();

                session_regenerate_id();
                
                $_SESSION["user_id"] = $user["id"];
                echo "<script> alert('Login successful')
                window.location.href = '../pages/index.php'
                </script>";
            } else {
                echo "<script> alert('Incorrect Login')
                window.location.href = '../index.html'
                </script>";

                die();
            }
        } else {
            echo "<script> alert('Admin not found')
                window.location.href = '../index.html'
                </script>";

                die();
        }
    } else {
        echo "query_error";
        die();
    }

    exit;
}
