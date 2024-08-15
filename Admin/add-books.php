<?php
$mysqli = require __DIR__ . "/database.php";

if ($mysqli->connect_errno) {
    die("Connection error: " . $mysqli->connect_error);
}

// Check if form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Retrieve form data
    $title = $_POST["title"];
    $author = $_POST["author"];
    $file = $_POST["file"];

    //Comment
    // Check if file was uploaded successfully
    if (isset($_FILES["image"]) && $_FILES["image"]["error"] === UPLOAD_ERR_OK) {
        // Retrieve uploaded file details
        $img_name = $_FILES["image"]["name"];
        $img_size = $_FILES["image"]["size"];
        $tmp_name = $_FILES["image"]["tmp_name"];
        $error = $_FILES["image"]["error"];

        // Validate image size
        if ($img_size > 1000000) {
            echo "<script>alert('Sorry, your file is too large.'); window.location.href = './pages/books.php';</script>";
            exit;
        } else {
            $img_ex = pathinfo($img_name, PATHINFO_EXTENSION);
            $img_ex_lc = strtolower($img_ex);

            $allowed_exs = array("jpg", "jpeg", "png", "gif");

            if (in_array($img_ex_lc, $allowed_exs)) {
                // Generate a new unique name for the image
                $new_img_name = uniqid("IMG-", true) . '.' . $img_ex_lc;
                $img_upload_path = __DIR__ . './uploads/' . $new_img_name;

                // Move uploaded image to destination folder
                if (move_uploaded_file($tmp_name, $img_upload_path)) {
                    // Prepare SQL statement to insert data into 'book' table
                    $sql = "INSERT INTO book (title, author, file, image) VALUES (?, ?, ?, ?)";

                    // Prepare and bind parameters
                    $stmt = $mysqli->prepare($sql);
                    $stmt->bind_param("ssss", $title, $author, $file, $new_img_name);

                    // Execute the statement
                    if ($stmt->execute()) {
                        // Redirect to success page or show a success message
                        echo "<script>alert('Successfully added'); window.location.href = './pages/books.php';</script>";
                        exit;
                    } else {
                        // Redirect to error page or show an error message
                        echo "Error: " . $stmt->error;
                        exit;
                    }
                } else {
                    echo "<script>alert('Error moving uploaded file'); window.location.href = './pages/books.php';</script>";
                    exit;
                }
            } else {
                echo "<script>alert('You cannot upload files of this type'); window.location.href = './pages/books.php';</script>";
                exit;
            }
        }
    } else {
        echo "Error uploading file: " . $_FILES["image"]["error"];
        exit;
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ADD BOOKS</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/water.css@2/out/water.css">
</head>

<body>
    <h2>Add a New Book</h2>
    <form action="add-books.php" method="post" enctype="multipart/form-data">
        <label for="title">Title:</label><br>
        <input type="text" id="title" name="title" required><br>

        <label for="author">Author:</label><br>
        <input type="text" id="author" name="author" required><br>

        <label for="file">Link:</label><br>
        <input type="text" id="file" name="file" required><br>

        <label for="image">Image:</label><br>
        <input type="file" id="image" name="image" accept="image/png, image/jpeg, image/gif" required><br>

        <input type="submit" value="Add Book">
    </form>
</body>

</html>