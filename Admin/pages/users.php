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
    <title>USERS MANAGEMENT</title>

    <!-- Montserrat Font -->
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@100;200;300;400;500;600;700;800;900&display=swap" rel="stylesheet">

    <!-- Material Icons -->
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons+Outlined" rel="stylesheet">

    <!-- Custom CSS -->

    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css">

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/5.3.0/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/2.0.8/css/dataTables.bootstrap5.css">
    <link rel="stylesheet" href="../css/users.css">



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
                    <p class="fs-4 fw-bold" style="color: rgb(0, 0, 0);">User Management</p>
                    <button type="button" class="btn btn-primary float-end" data-bs-toggle="modal" data-bs-target="#exampleModal">
                        Add User Profile
                    </button>
                </div>

                <!-- MODAL ADD USER -->

                <!-- Button trigger modal -->


                <!-- Modal -->
                <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h3 class="modal-title fs-5" style="color:rgb(0, 0, 0)" id="exampleModalLabel">Add New User</h3>
                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                            </div>


                            <!-- ADD USER FORM -->

                            <form action="../scripts/process-add-user.php" method="POST">
                                <div class="modal-body">

                                    <div class="form-group">
                                        <label style="color:rgb(0, 0, 0)">Full name</label>
                                        <input type="text" placeholder="Full Name" id="name" name="name" class="form-control" required>
                                    </div>
                                    <div class="form-group">
                                        <label style="color:rgb(0, 0, 0)">Email</label>
                                        <input type="email" placeholder="Email" id="email" class="form-control" name="email" required>
                                    </div>
                                    <div class="form-group">
                                        <label style="color:rgb(0, 0, 0)">Password</label>
                                        <input type="password" placeholder="Password" id="password" class="form-control" name="password" required>
                                    </div>
                                    <div class="form-group">
                                        <label style="color:rgb(0, 0, 0)">Confirm Password</label>
                                        <input type="password" placeholder="Confirm Password" id="password_confirmation" class="form-control" name="password_confirmation" required>
                                    </div>

                                </div>
                            </form>


                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                <button type="button" name="adduserbtn" class="btn btn-primary">Save</button>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- END Modal -->


                <table id="example" class="table table-striped" style="width:100%">
                    <thead>
                        <tr>
                            <th>Name</th>
                            <th>Email</th>
                            <th>Password</th>
                            <th>Reset Token</th>
                            <th>Reset Token Expiry Time</th>
                            <th>Last Active</th>
                            <th>Actions</th> <!-- Added this line -->
                        </tr>
                    </thead>
                    <tbody>
                        <!-- Students will be added here dynamically -->
                        <?php
                        $mysqli = require __DIR__ . "/database.php";

                        $sql = "SELECT * FROM user";
                        $result = $mysqli->query($sql);
                        while ($row = mysqli_fetch_assoc($result)) {
                        ?>
                            <tr>
                                <!--<td><?php echo $row['id'] ?></td>-->
                                <td><?php echo $row['name'] ?></td>
                                <td><?php echo $row['email'] ?></td>
                                <td><?php echo $row['password_hash'] ?></td>
                                <td><?php echo $row['reset_token_hash'] ?></td>
                                <td><?php echo $row['reset_token_expires_at'] ?></td>
                                <td><?php echo $row['last_active'] ?></td>
                                <td style="display: flex; gap: 10px;">

                                    <a><button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#exampleModaledit">
                                            Edit
                                        </button></a>

                                    <!-- Modal -->
                                    <div class="modal fade" id="exampleModaledit" tabindex="-1" aria-labelledby="exampleModalLabeledit" aria-hidden="true">
                                        <div class="modal-dialog">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h3 class="modal-title fs-5" style="color:rgb(0, 0, 0)" id="exampleModalLabeledit">Edit User</h3>
                                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                </div>


                                                <!-- EDIT USER FORM -->

                                                <!-- EDIT USER FORM -->
                                                <form action="../scripts/process-edit-user.php" method="POST">
                                                    <div class="modal-body">
                                                        <div class="form-group">
                                                            <label style="color:rgb(0, 0, 0)">Full name</label>
                                                            <input type="text" placeholder="Full Name" id="name" name="name" class="form-control" required>
                                                        </div>
                                                        <div class="form-group">
                                                            <label style="color:rgb(0, 0, 0)">Email</label>
                                                            <input type="email" placeholder="Email" id="email" class="form-control" name="email" required>
                                                        </div>
                                                    </div>


                                                    <div class="modal-footer">
                                                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                                        <button type="submit" name="edituserbtn" class="btn btn-primary">Save Changes</button>
                                                    </div>
                                                </form>

                                            </div>
                                        </div>
                                    </div>
                                    <!-- END Modal -->

                                    <a><button type="button" class="btn btn-danger delete-button" data-bs-toggle="modal" data-bs-target="#exampleModaldelete" data-user-email="<?php echo $row['email']; ?>">
                                            Delete
                                        </button>
                                    </a>

                                    <!-- Modal -->
                                    <div class="modal fade" id="exampleModaldelete" tabindex="-1" aria-labelledby="exampleModalLabeldelete" aria-hidden="true">
                                        <div class="modal-dialog">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h5 class="modal-title" id="exampleModalLabeldelete">DELETE USER</h5>
                                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                </div>
                                                <div class="modal-body">
                                                    Are you sure you want to delete user <span id="user-email-to-delete"></span>?
                                                </div>
                                                <div class="modal-footer">
                                                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                                                    <button type="button" name="deleteuserbtn" class="btn btn-danger" id="confirm-delete">Delete</button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>



                                    <script>
                                        document.addEventListener("DOMContentLoaded", function() {
                                            const deleteButtons = document.querySelectorAll(".delete-button");

                                            deleteButtons.forEach(button => {
                                                button.addEventListener("click", function() {
                                                    const userEmail = this.getAttribute('data-user-email');
                                                    const deleteConfirmButton = document.getElementById('confirm-delete');
                                                    const userEmailToDeleteSpan = document.getElementById('user-email-to-delete');

                                                    // Set the email in the modal confirmation message
                                                    userEmailToDeleteSpan.textContent = userEmail;

                                                    // Set up the confirmation modal
                                                    deleteConfirmButton.addEventListener('click', function() {
                                                        // AJAX request to delete the user
                                                        fetch(`delete_user.php?email=${encodeURIComponent(userEmail)}`, {
                                                                method: 'DELETE'
                                                            })
                                                            .then(response => {
                                                                if (!response.ok) {
                                                                    throw new Error('Network response was not ok');
                                                                }
                                                                return response.json();
                                                            })
                                                            .then(data => {
                                                                // Assuming deletion was successful, you can remove the row from the table
                                                                // For example:
                                                                const rowToDelete = button.closest('tr');
                                                                rowToDelete.remove();
                                                                // Optionally, close the modal after deletion
                                                                const deleteModal = document.getElementById('exampleModaldelete');
                                                                const modal = bootstrap.Modal.getInstance(deleteModal);
                                                                modal.hide();
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
                            <th>Name</th>
                            <th>Email</th>
                            <th>Password</th>
                            <th>Reset Token</th>
                            <th>Reset Token Expiry Time</th>
                            <th>Last Active</th>
                            <th>Actions</th> <!-- Added this line -->
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
                <script>
                    document.querySelector('button[name="adduserbtn"]').addEventListener('click', function() {
                        document.querySelector('form').submit();
                    });
                </script>
                <script>
                    document.querySelector('button[name="edituserbtn"]').addEventListener('click', function() {
                        document.querySelector('form').submit();
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