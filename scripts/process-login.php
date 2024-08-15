<?php
// DATABASE CONNECTION
$mysqli = require __DIR__ . "/database.php";

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $emaillog = $mysqli->real_escape_string($_POST["emaillog"]);

    $sql = "SELECT * FROM user WHERE email = '$emaillog'";
    $result = $mysqli->query($sql);

    if ($result) {
        $user = $result->fetch_assoc();

        if ($user) {
            if (password_verify($_POST["passwordlog"], $user["password_hash"])) {

                $current_time = date('Y-m-d H:i:s');
                $update_sql = "UPDATE user SET last_active = '$current_time' WHERE id = " . $user["id"];
                $mysqli->query($update_sql);

                session_start();
                session_regenerate_id();

                $_SESSION["user_id"] = $user["id"];
                echo "<script> alert('Login successful');
                window.location.href = '../pages/index.php';
                </script>";
            } else {
                echo "<script> alert('Incorrect Login');
                window.location.href = '../pages/login-register.html';
                </script>";
                die();
            }
        } else {
            echo "<script> alert('User not found');
                window.location.href = '../pages/login-register.html';
                </script>";
            die();
        }
    } else {
        echo "query_error";
        die();
    }

    exit;
}
