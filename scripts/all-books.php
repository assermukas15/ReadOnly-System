<?php

session_start();

if (isset($_SESSION["user_id"])) {

    $mysqli = require __DIR__ . "/database.php";

    $sql = "SELECT * FROM user WHERE id = {$_SESSION["user_id"]}";

    $result = $mysqli->query($sql);

    $user = $result->fetch_assoc();
}

?>


<!-- HTML OF USER HOME -->

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../styles/books.css">
    <title>HOME</title>
</head>


<!-- THE HEADER OF THE PAGE SECTION -->

<header class="site-header">
    <div class="logo">
        <a href="../pages/index.php"><img src="../images/logos/logo-1.png" alt="University Logo"></a>
    </div>
    <div class="search">
        <form action="../pages/search-page.php" method="get">
            <input placeholder="Search..." type="text" name="query" required>
            <button type="submit">Go</button>
        </form>
    </div>


    <nav class="main-nav">
        <ul>
            <li><a href="../pages/index.php">Home</a></li>
            <li><a href="../scripts/all-books.php">Books</a></li>
        </ul>
    </nav>
    <div class="username">
        <h4>Hello, &nbsp; <?= htmlspecialchars($user["name"]) ?>&nbsp;&nbsp;</h4>
    </div>
</header>


<section>
    <hr>
    <br>
    <div class="all-books">
        <h3> ALL BOOKS </h3>
    </div>
</section>
<br><br><br><br><br><br>

<section id="books-sec" class="books-section">

    <!-- BOOKS DISPLAY -->
    <?php
    $mysqli = require __DIR__ . "/database.php";

    if ($mysqli->connect_errno) {
        die("Connection error: " . $mysqli->connect_error);
    }

    // Fetch data from the 'book' table
    $sql = "SELECT title, author, image, file FROM book";
    $result = $mysqli->query($sql);
    ?>

    <div class="list-books">
        <?php while ($row = $result->fetch_assoc()) : ?>
            <div class="books-container">
                <a href="<?php echo $row['file']; ?>" target="_blank" class="image-wrapper">
                    <img src="../Admin/uploads/<?php echo $row['image']; ?>" alt="<?php echo $row['title']; ?>" class="book-image">
                </a>
                <div class="book-info">
                    <p><?php echo $row['title']; ?></p>
                    <p>By <?php echo $row['author']; ?></p>
                </div>
            </div>
        <?php endwhile; ?>
    </div>
</section>





<footer class="copyright">

</footer>




<style>
    .copyright {
        margin-left: 100px;
        margin-right: 100px;
        text-align: center;
        font-size: small;
    }

    .books-container {
        transition: .9s ease;
    }

    .books-container:hover {
        transform: scale(1.1);
        box-shadow: 0 0 10px rgba(0, 0, 0, 0.5);
    }
</style>
</body>

</html>