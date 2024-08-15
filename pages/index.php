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
    <link rel="stylesheet" href="../styles/h-user.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <title>HOME</title>
</head>

<!-- SESSION CHEKING -->

<?php if (isset($user)) : ?>

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
                <li><a href="#hero">Home</a></li>
                <li><a href="../scripts/all-books.php">All books</a></li>
                <li><a href="#contact">Contact</a></li>
            </ul>
        </nav>
        <div class="username">
            <h4>Hello, &nbsp; <?= htmlspecialchars($user["name"]) ?>&nbsp;&nbsp;<a href="../scripts/logout.php"> log out</a></h4>
        </div>
    </header>

    <!-- WELCOME TO HERO SECTION -->

    <!--welcome-hero start -->
    <section id="hero" class="welcome-hero">
        <div class="container">
            <div class="welcome-hero-txt">
                <h2>Your writings are proctected</h2>
                <h3>Read Only Library</h3>
                <p>"The only thing you absolutely have to know, is the location of the library" Albert Einstein</p>
            </div>
        </div>
    </section><!--/.welcome-hero-->
    <!--welcome-hero end -->


    <!-- THE BOOKS section -->


    <section>
        <hr>
        <div class="title-books">
            <h3> Books </h3>
        </div>
        <hr>
    </section>
    <br><br><br><br><br><br>


    <section id="books-sec">
        <?php
        $mysqli = require __DIR__ . "/database.php";

        if ($mysqli->connect_errno) {
            die("Connection error: " . $mysqli->connect_error);
        }

        // Fetch data from the 'book' table with a LIMIT of 10 
        $sql = "SELECT title, author, image, file FROM book LIMIT 5";
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
        <!-- View All Books Button -->
        <div class="view-all-books">
            <a href="../scripts/all-books.php"><button type="submit">
                    <p>View all books</p>
                </button></a>
        </div>
    </section>





    <section id="about" class="about-us">
        <br>
        <br>
        <div class="about-title">
            <h3> About us </h3>
        </div>
        <br>
        <div class="about-cont">
            <p>Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since the 1500s,
                when an unknown printer took a galley of type and scrambled it to make a type specimen book.
                It has survived not only five centuries, but also the leap into electronic typesetting,
                remaining essentially unchanged. It was popularised in the 1960s with the release of
                Letraset sheets containing Lorem Ipsum passages, and more recently with desktop publishing software like Aldus PageMaker including versions of Lorem Ipsum.
                Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since the 1500s,
                when an unknown printer took a galley of type and scrambled it to make a type specimen book.
                It has survived not only five centuries, but also the leap into electronic typesetting,
                remaining essentially unchanged. It was popularised in the 1960s with the release of
                Letraset sheets containing Lorem Ipsum passages, and more recently with desktop publishing software like Aldus PageMaker including versions of Lorem Ipsum.<br>
                Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since the 1500s,
                when an unknown printer took a galley of type and scrambled it to make a type specimen book.
                It has survived not only five centuries, but also the leap into electronic typesetting,
                remaining essentially unchanged. It was popularised in the 1960s with the release of
                Letraset sheets containing Lorem Ipsum passages, and more recently with desktop publishing software like Aldus PageMaker including versions of Lorem Ipsum.

            </p>
        </div>
    </section>
    <br><br>





    <section id="contact" class="Contact-section">
        <div class="about-title">
            <h3> Contact us </h3>
        </div>
        <div class="contact">
            <img src="../images/other/Contacts.png" alt="">
        </div>
    </section>










    <footer class="copyright">
    </footer>





<?php else : ?>
    echo "<script>
        alert('Please register')
        window.location.href = './login-register.html'
    </script>";
<?php endif; ?>
<style>
    .view-all-books {
        display: flex;
        justify-content: center;
        margin-top: 0;
        margin-bottom: 50px;
    }

    .view-all-books button[type="submit"] {

        background-color: rgb(255, 255, 255);
        border: unset;
        border-radius: 10px;
        z-index: 1;
        font-weight: bold;
        font-size: 20px;
        color: rgb(160, 0, 42);
        cursor: pointer;
        padding: 1px 80px;
        position: relative;
        transition: all 250ms;
    }

    .view-all-books button[type="submit"]:hover {
        transform: scale(1.1);
        color: rgb(255, 255, 255);
        background-color: rgb(160, 0, 42);
    }


    .about-cont {
        margin-left: 150px;
        margin-right: 150px;
        font-size: large;
        font-weight: normal;
        text-align: center;
    }


    .title-books {
        text-align: right;
        margin-right: 200px;
    }

    .title-books h3 {
        background-color: rgb(160, 0, 42);
        padding: 15px 10px;
        font-weight: bold;
        text-transform: capitalize;
        font-size: 15px;
        color: rgb(255, 255, 255);
        cursor: pointer;
        transition: .9s ease;
    }

    .title-books h3:hover {
        transform: scale(1);
        color: rgb(246, 150, 28);
    }



    .about-us {
        background-color: rgb(255, 255, 255);
    }

    .about-title {
        text-align: right;
        margin-right: 200px;

    }

    .about-title h3 {
        background-color: rgb(160, 0, 42);
        padding: 15px 10px;
        font-weight: bold;
        text-transform: capitalize;
        font-size: 15px;
        color: rgb(255, 255, 255);
        cursor: pointer;
        transition: .9s ease;
    }

    .about-title h3:hover {
        transform: scale(1);
        color: rgb(246, 150, 28);
    }

    .copyright {
        margin-left: 100px;
        margin-right: 100px;
        text-align: center;
    }

    .Contact-section {
        background-color: rgb(255, 255, 255);
        background-size: cover;
        justify-content: center;
        padding-top: 10px;
    }
</style>
</body>

</html>