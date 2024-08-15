<?php

session_start();

if (isset($_SESSION["user_id"])) {

    $mysqli = require __DIR__ . "/database.php";

    $sql = "SELECT * FROM user WHERE id = {$_SESSION["user_id"]}";

    $result = $mysqli->query($sql);

    $user = $result->fetch_assoc();
}

?>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../styles/search-page.css">
    <title>Search...</title>
</head>

<body>


    <header class="site-header">
        <div class="logo">
            <a href="../pages/index.php"><img src="../images/logos/logo-1.png" alt="University Logo"></a>
        </div>
        <div class="search">
            <form action="../pages/search-page.php" method="get">
                <input placeholder="Search..." type="text" name="query">
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
    <br>



    <section>

        <div class="all-books">
            <a href="../scripts/all-books.php" style="text-decoration: none;">
                <h3>> VIEW ALL BOOKS</h3>
            </a>
        </div>
        <div class=" s-results">
            <h2>SEARCH RESULT FOR '<?= isset($_GET['query']) ? htmlspecialchars($_GET['query']) : '' ?>' :
                <hr> <br><br><br><br>
            </h2>
        </div>
        <?php
        // Include the database connection
        $mysqli = require __DIR__ . "/database.php";

        // Check if the search query is set and not empty
        if (isset($_GET['query']) && !empty($_GET['query'])) {
            $searchQuery = $mysqli->real_escape_string($_GET['query']);

            // Prepare the SQL query
            $sql = "SELECT title, author, image, file FROM book WHERE title LIKE ? OR author LIKE ?";
            $stmt = $mysqli->prepare($sql);
            $searchTerm = "%" . $searchQuery . "%";
            $stmt->bind_param("ss", $searchTerm, $searchTerm);

            // Execute the query
            $stmt->execute();
            $result = $stmt->get_result();

            // Check if there are any results
            if ($result->num_rows > 0) {
                echo "<div class='list-books'>";
                // Fetch and display the results
                while ($row = $result->fetch_assoc()) {
                    echo "<div class='books-container'>";
                    echo "<a href='" . $row['file'] . "' target='_blank' class='image-wrapper'>";
                    echo "<img src='../Admin/uploads/" . $row['image'] . "' alt='" . $row['title'] . "' class='book-image'>";
                    echo "</a>";
                    echo "<div class='book-info'>";
                    echo "<p>" . $row['title'] . "</p>";
                    echo "<p>By " . $row['author'] . "</p>";
                    echo "</div>";
                    echo "</div>";
                }
                echo "</div>";
            } else {
                echo "<center><p>No results found for '<strong>" . htmlspecialchars($searchQuery) . "</strong>'</p></center><br>
            <br><br><br><br><br><br><br><br><br>";
            }

            // Close the statement
            $stmt->close();
        } else {
            echo "<center><p>Please enter a search term.</p></center><br>
            <br><br><br><br><br><br><br><br><br>";
        }

        // Close the database connection
        $mysqli->close();
        ?>
        <br>
        <br><br><br>
        <br><br><br><br><br><br><br><br><br>
        <hr>
        <hr>
        <hr>
    </section>






    <br>
    <footer class="copyright">
    </footer>







    <style>
        .copyright {
            margin-left: 100px;
            margin-right: 100px;
            text-align: center;
            font-size: small;
        }

        /*-------------------------------------
        1.  HEADER SECTION
--------------------------------------*/

        .site-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 20px 20px;
            min-width: 750px;
            background-color: #f9f9f9;
            position: sticky;
            top: 0;
            z-index: 1000;
        }

        .logo img {
            max-width: 300px;
            height: auto;
        }

        .main-nav {
            position: relative;
            left: 150px;
        }

        .main-nav ul {
            list-style: none;
            margin: 0;
            padding: 0;
            justify-content: space-between;
        }

        .main-nav li {
            display: inline-block;
            margin-right: 20px;
            position: relative;
        }

        .main-nav a {
            text-decoration: none;
            color: #333;
            font-weight: bold;
            transition: color 0.3s ease;
            font-family: 'Spartan', sans-serif;
            /* Apply Spartan font */
        }

        .main-nav a:hover {
            color: rgba(160, 0, 42);
        }

        .username {
            text-decoration: none;
        }

        .username a {
            background-color: rgb(160, 0, 42);
            padding: 10px 10px;
            text-decoration: none;
            text-transform: lowercase;
            font-weight: normal;
            font-size: 15px;
            color: rgb(255, 255, 255);
            cursor: pointer;
            transition: .9s ease;
        }

        .username a:hover {
            transform: scale(1.1);
            color: rgb(246, 150, 28);
        }

        /*-------------------------------------
        2.  SEARCH BAR
--------------------------------------*/

        .search {
            display: inline-block;
            position: relative;
            left: 300px;
        }

        .search input[type="text"] {
            font-size: 18px;
            width: 400px;
            padding: 10px;
            border: unset;
            border-radius: 10px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.5);
        }

        .search button[type="submit"] {
            background-color: rgba(246, 150, 28);
            border: unset;
            border-top-right-radius: 10px;
            border-bottom-right-radius: 10px;
            color: white;
            cursor: pointer;
            padding: 13px 20px;
            position: absolute;
            top: 0;
            right: 0;
            transition: .9s ease;
        }

        .search button[type="submit"]:hover {
            transform: scale(1.1);
            color: rgb(255, 255, 255);
            background-color: rgba(160, 0, 42);
        }
    </style>
</body>

</html>