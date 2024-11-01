<?php
session_start();

// Check if the user is logged in as an admin
if (!isset($_SESSION["user_id"]) || $_SESSION["role"] !== "admin") {
    header("Location: index.php");
    exit();
}
$hostname = "localhost";
$username = "root";
$password = "E7DnO9eoP7Clc9Zw";
$database = "devprog_panel";

$conn = new mysqli($hostname, $username, $password, $database);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
?>

<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>Admin Dashboard</title>
    <!-- Add Bootstrap CSS link -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="style.css">
</head>

<body>
    <div class="container mt-5">
        <div class="dashboard-container">
            <h2 class="welcome-message">Welcome,
                <?php echo $_SESSION["username"]; ?> (Admin)
            </h2>
            <p class="dashboard-description">This is the admin dashboard. You can view and manage your account here.</p>
            <a href="logout.php" class="btn btn-danger logout-link">Logout</a>
            <h3 class="user-list-title">User List</h3>
            <table class="table table-bordered text-center">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Username</th>
                        <th>Role</th>
                        <th>Action</th> <!-- Add a new column for actions -->
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $sql = "SELECT * FROM users WHERE role='user'";
                    $result = $conn->query($sql);

                    if ($result->num_rows > 0) {
                        while ($row = $result->fetch_assoc()) {
                            echo "<tr>";
                            echo "<td>" . $row["id"] . "</td>";
                            echo "<td>" . $row["username"] . "</td>";
                            echo "<td>" . $row["role"] . "</td>";
                            echo "<td class='text-center align-middle'>";
                            echo "<div class='d-flex justify-content-center'>";
                            echo "<button class='btn btn-primary modify-button'
                                data-toggle='modal'
                                data-target='#modifyUserModal'
                                data-userid='" . $row['id'] . "'
                                data-username='" . $row['username'] . "'
                                data-role='" . $row['role'] . "'
                            ><i class='fas fa-edit'></i> </button>";
                            echo "<button class='btn btn-danger ml-3 delete-button'data-userid='" . $row['id'] . "'><i class='fas fa-trash'></i></button>";
                            echo "</div>";
                            echo "</td>";
                            echo "</tr>";
                        }
                    } else {
                        echo "<tr><td colspan='4'>No users found.</td></tr>";
                    }

                    $conn->close();
                    ?>
                </tbody>
            </table>
        </div>
    </div>

    <!-- Bootstrap Modal for Modify User -->
    <div class="modal fade" id="modifyUserModal" tabindex="-1" aria-labelledby="modifyUserModalLabel"
        aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="modifyUserModalLabel">Modify User</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form method="POST">
                        <div class="form-group">
                            <label for="modifiedUsername">New Username</label>
                            <input type="text" class="form-control" id="modifiedUsername" name="modifiedUsername"
                                placeholder="Enter new username">
                        </div>
                        <div class="form-group">
                            <label for="modifiedRole">New Role</label>
                            <input type="text" class="form-control" id="modifiedRole" name="modifiedRole"
                                placeholder="Enter new role">
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-primary" id="saveChangesButton">Save changes</button>
                </div>
            </div>
        </div>
    </div>

    <!-- Add Bootstrap JS and jQuery links (optional) -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.3.0/css/all.min.css">
    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.3/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>

    <script>
        $(document).ready(function () {

            // Handle the click event of the "Delete" button
            $('.delete-button').click(function () {
                var userId = $(this).data('userid'); // Retrieve user ID from the clicked button

                // Show a confirmation dialog
                if (confirm("Are you sure you want to delete this user?")) {
                    // Send an AJAX request to delete the user
                    $.ajax({
                        type: 'POST',
                        url: 'crud/delete_user.php', // Replace with the correct path to your delete_user.php script
                        data: {
                            userid: userId
                        },
                        success: function (response) {
                            // Handle the server response here (e.g., show a success message)
                            console.log(response);

                            // Optionally, you can refresh the page after successful deletion
                            location.reload();
                        },
                        error: function (error) {
                            // Handle errors, if any
                            console.error(error);
                        }
                    });
                }
            });


            $('.modify-button').click(function () {
                var userId = $(this).data('userid'); // Retrieve user ID from the clicked button
                var username = $(this).data('username');
                var role = $(this).data('role');

                // Set the input field values in the modal
                $('#modifiedUsername').val(username);
                $('#modifiedRole').val(role);

                // Store the user ID in a data attribute of the "Save changes" button
                $('#saveChangesButton').data('userid', userId);
            });

            $('#saveChangesButton').click(function () {
                // Retrieve modified data from the modal and submit it to the server
                var modifiedUsername = $('#modifiedUsername').val();
                var modifiedRole = $('#modifiedRole').val();
                var userId = $(this).data('userid'); // Retrieve user ID from the button data

                // Send an AJAX request to update the user data on the server
                $.ajax({
                    type: 'POST',
                    url: 'crud/update_user.php', // Replace with your server-side script to update user data
                    data: {
                        userid: userId,
                        username: modifiedUsername,
                        role: modifiedRole
                    },
                    success: function (response) {
                        // Handle the server response here (e.g., show a success message)
                        console.log(response);

                        // Close the modal
                        $('#modifyUserModal').modal('hide');

                        // Reload the page after a short delay (e.g., 1 second)
                        location.reload();

                    },


                    error: function (error) {
                        // Handle errors, if any
                        console.error(error);
                    }
                });
            });
        });
    </script>
</body>

</html>