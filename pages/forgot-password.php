<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../styles/forgot-password.css">
    <title>READ ONLY SYSTEM</title>
</head>
<body>

    <!-- THE HEADER OF THE PAGE SECTION -->

    <header class="site-header">
        <div class="logo">
            <a href="../index.html"><img src="../images/logos/logo-1.png" alt="University Logo"></a>
        </div>
        <nav class="main-nav">
            <ul>
                <li><a class="active" href="../index.html">Home</a></li>
                <li><a href="../pages/login-register.html">Register & Login</a></li>
            </ul>
        </nav>
    </header>

    <!-- FORGOT PASSWORD SECTION -->

    <div class="background"></div>
    <div class="form-container">
        <form id="forgot-password-form" action="../scripts/send-password-reset.php" method="post">
            <h2>Forgot Password</h2>
            <p>Enter your email address to receive a password reset link.</p>
            <input type="email" name="email" placeholder="Email" id="email" required>
            <button type="submit">Submit</button>
        </form>
    </div>


    


    <!-- JavaScript linking point to the index page of the website -->
    
</body>
</html>
