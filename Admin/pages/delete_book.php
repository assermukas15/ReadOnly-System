<?php
$mysqli = require __DIR__ . "/database.php";

if ($mysqli->connect_errno) {
    die("Connection error: " . $mysqli->connect_error);
}

if ($_SERVER['REQUEST_METHOD'] === 'DELETE') {
    // Assuming 'title' is sent as a query parameter
    $bookTitle = $_GET['title'];

    $sql = "DELETE FROM book WHERE title = ?";
    $stmt = $mysqli->prepare($sql);
    $stmt->bind_param("s", $bookTitle);

    if ($stmt->execute()) {
        // Return success response
        echo json_encode(["message" => "Book deleted successfully"]);
        exit();
    } else {
        http_response_code(500); // Internal Server Error
        echo json_encode(["error" => "Error deleting book"]);
        exit();
    }
}
