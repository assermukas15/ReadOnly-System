<?php

session_start();

if (isset($_SESSION["user_id"])) {

    $mysqli = require __DIR__ . "/database.php";

    $sql = "SELECT * FROM administrator WHERE id = {$_SESSION["user_id"]}";

    $result = $mysqli->query($sql);

    $user = $result->fetch_assoc();
}

?>



<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width,initial-scale=1.0">
    <title>BOOKS MANAGEMENT</title>

    <!-- Montserrat Font -->
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@100;200;300;400;500;600;700;800;900&display=swap" rel="stylesheet">

    <!-- Material Icons -->
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons+Outlined" rel="stylesheet">

    <!-- Custom CSS -->

    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css">

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/5.3.0/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/2.0.8/css/dataTables.bootstrap5.css">
    <link rel="stylesheet" href="../css/books.css">



</head>

<?php if (isset($user)) : ?>

    <body>
        <div class="grid-container">

            <!-- Header -->
            <header class="header">
                <div class="menu-icon" onclick="openSidebar()">
                    <span class="material-icons-outlined">menu</span>
                </div>
                <div class="header-right">
                    <h6>Hello, &nbsp; <?= htmlspecialchars($user["name"]) ?>&nbsp;&nbsp;<a href="../scripts/logout.php"> log out</a></h6>
                </div>
            </header>
            <!-- End Header -->

            <!-- Sidebar -->
            <aside id="sidebar">
                <div class="sidebar-title">
                    <div class="sidebar-brand">
                        <span class="material-icons-outlined"></span>READ ONLY System
                    </div>
                    <span class="material-icons-outlined" onclick="closeSidebar()">close</span>
                </div>

                <ul class="sidebar-list">
                    <li class="sidebar-list-item">
                        <a href="./index.php">
                            <span class="material-icons-outlined">dashboard</span>&nbsp; Dashboard
                        </a>
                    </li>
                    <li class="sidebar-list-ite">
                        <p>
                            <span class="material-icons-outlined"></span><b>&nbsp;| Management |</b>
                        </p>
                    </li>
                    <li class="sidebar-list-item">
                        <a href="./books.php">
                            <span class="material-icons-outlined">menu_book</span>&nbsp; Books
                        </a>
                    </li>
                    <li class="sidebar-list-item">
                        <a href="./users.php">
                            <span class="material-icons-outlined">groups</span>&nbsp; Users
                        </a>
                    </li>
                    <li class="sidebar-list-item">
                        <a href="./admins.php">
                            <span class="material-icons-outlined">admin_panel_settings</span>&nbsp; Admins
                        </a>
                    </li>
                    <li class="sidebar-list-item">
                        <a href="./reports.php">
                            <span class="material-icons-outlined">poll</span>&nbsp; Reports
                        </a>
                    </li>
                    <!--
          <li class="sidebar-list-item">
            <a href="#" target="_blank">
              <span class="material-icons-outlined">settings</span>&nbsp; Settings
            </a>
          </li>
          -->
                </ul>
            </aside>

            <!-- End Sidebar -->

            <!-- Main -->
            <main class="main-container" style="background-color: rgb(255, 255, 255);">

                <div class="container">
                    <p class="fs-4 fw-bold" style="color: rgb(0, 0, 0);">Books Management</p>
                    <a href="../add-books.php"> <button type="button" class="btn btn-success float-end">
                            Add Book Profile
                        </button></a>
                </div>





                <table id="example" class="table table-striped" style="width:100%">
                    <thead>
                        <tr>
                            <th>Title</th>
                            <th>Author</th>
                            <th>File</th>
                            <th>Image</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <!-- Students will be added here dynamically -->
                        <?php
                        $mysqli = require __DIR__ . "/database.php";

                        $sql = "SELECT * FROM book";
                        $result = $mysqli->query($sql);
                        while ($row = mysqli_fetch_assoc($result)) {
                        ?>
                            <tr>
                                <td><?php echo $row['title'] ?></td>
                                <td><?php echo $row['author'] ?></td>
                                <td><?php echo $row['file'] ?></td>
                                <td><?php echo $row['image'] ?></td>
                                <td style="display: flex; gap: 10px;">


                                    <a><button type="button" class="btn btn-danger delete-button" data-bs-toggle="modal" data-bs-target="#exampleModaldelete" data-user-title="<?php echo $row['title']; ?>">
                                            Delete
                                        </button></a>

                                    <!-- Delete Confirmation Modal -->
                                    <div class="modal fade" id="exampleModaldelete" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                        <div class="modal-dialog">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h5 class="modal-title" id="exampleModalLabel">Confirm Deletion</h5>
                                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                </div>
                                                <div class="modal-body">
                                                    Do you want to delete <span id="bookTitle"></span>?
                                                </div>
                                                <div class="modal-footer">
                                                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                                                    <button type="button" name="deletebookbtn" class="btn btn-danger" id="confirmDelete">Yes, Delete</button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <script>
                                        document.addEventListener("DOMContentLoaded", function() {
                                            const deleteButtons = document.querySelectorAll(".delete-button");

                                            deleteButtons.forEach(button => {
                                                button.addEventListener("click", function() {
                                                    const bookTitle = this.getAttribute('data-user-title');
                                                    const confirmDeleteButton = document.getElementById('confirmDelete');
                                                    const bookTitleToDeleteSpan = document.getElementById('bookTitle');

                                                    // Set the book title in the modal confirmation message
                                                    bookTitleToDeleteSpan.textContent = bookTitle;

                                                    // Set up the confirmation modal
                                                    confirmDeleteButton.addEventListener('click', function() {
                                                        // AJAX request to delete the book
                                                        fetch(`delete_book.php?title=${encodeURIComponent(bookTitle)}`, {
                                                                method: 'DELETE'
                                                            })
                                                            .then(response => {
                                                                if (!response.ok) {
                                                                    throw new Error('Network response was not ok');
                                                                }
                                                                return response.json();
                                                            })
                                                            .then(data => {
                                                                // Assuming deletion was successful, you can update the UI as needed
                                                                // For example: reload the page or remove the deleted book from the list
                                                                console.log('Book deleted successfully');
                                                                // Optionally, close the modal after deletion
                                                                const deleteModal = document.getElementById('exampleModaldelete');
                                                                const modal = bootstrap.Modal.getInstance(deleteModal);
                                                                modal.hide();
                                                                // Reload the page or update UI after deletion
                                                                // window.location.reload(); // Uncomment to reload the page
                                                            })
                                                            .catch(error => {
                                                                console.error('Error:', error);
                                                                // Handle errors here
                                                            });
                                                    });
                                                });
                                            });
                                        });
                                    </script>







                                </td>

                            </tr>
                        <?php
                        }
                        ?>
                    </tbody>
                    <tfoot>
                        <tr>
                            <th>Title</th>
                            <th>Author</th>
                            <th>File</th>
                            <th>Image</th>
                            <th>Action</th>
                        </tr>
                    </tfoot>
                </table>




                <script src="https://code.jquery.com/jquery-3.5.1.js"></script>
                <script src="https://cdn.datatables.net/1.13.1/js/jquery.dataTables.min.js"></script>
                <script src="https://cdn.datatables.net/1.13.1/js/dataTables.bootstrap5.min.js"></script>
                <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
                <script>
                    $(document).ready(function() {
                        $('#example').DataTable();
                    });
                </script>




            </main>
            <!-- End Main -->

        </div>

        <!-- Scripts -->
        <script src="../js/scripts.js"></script>




    <?php else : ?>
        echo "<script>
            alert('Please register')
            window.location.href = '../index.html'
        </script>";
    <?php endif; ?>

    </body>

</html>