<?php
// Connect to the MySQL database
$conn = new mysqli("localhost", "root", "E7DnO9eoP7Clc9Zw", "devprog_panel");

// Check the database connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Get the user ID from the POST data
    $userId = $_POST["userid"];

    // Delete the user from the database
    $sql = "DELETE FROM users WHERE id=?";
    $stmt = $conn->prepare($sql);

    if ($stmt === false) {
        die("Prepare failed: " . $conn->error);
    }

    $stmt->bind_param("i", $userId);

    if ($stmt->execute()) {
        // Deletion was successful
        echo "User deleted successfully.";
    } else {
        // Deletion failed
        echo "Error deleting user: " . $stmt->error;
    }

    $stmt->close();
} else {
    // Handle invalid request (not a POST request)
    echo "Invalid request.";
}

// Close the database connection
$conn->close();
?>
