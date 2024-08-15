<?php

$token = $_GET["token"];

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

?>



<!-- HTML RESET PASSWORD PAGE -->


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../styles/reset-password.css">
    <title>READ ONLY SYSTEM</title>
</head>
<body>

    <!-- THE HEADER OF THE PAGE SECTION -->

    <header class="site-header">
        <div class="logo">
        <a href="../pages/login-register.html"><img src="../images/logos/logo-1.png" alt="University Logo"></a>
        </div>
    </header>

    <!-- RESET PASSWORD SECTION -->

    <div class="background"></div>
    <div class="form-container">
        <form id="reset-password-form" action="../scripts/process-reset-password.php" method="post">
            <h2>Reset Password</h2>
            <input type="hidden" name="token" value="<?= htmlspecialchars($token) ?>">
            <input type="password" name="password" id="password" placeholder="New Password" required>
            <input type="password" name="password_confirmation" placeholder="Repeat Password" id="password_confirmation" required>
            <button type="submit">Send</button>
        </form>
    </div>


    




</body>
</html>
