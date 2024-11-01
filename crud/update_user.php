<?php
// Connect to the MySQL database
$conn = new mysqli("localhost", "root", "E7DnO9eoP7Clc9Zw", "devprog_panel");

// Check the database connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Get the user ID, modified username, and modified role from the POST data
    $userId = $_POST["userid"];
    $modifiedUsername = $_POST["username"];
    $modifiedRole = $_POST["role"];

    // Update the user data in the database
    $sql = "UPDATE users SET username=?, role=? WHERE id=?";
    $stmt = $conn->prepare($sql);

    if ($stmt === false) {
        die("Prepare failed: " . $conn->error);
    }

    $stmt->bind_param("ssi", $modifiedUsername, $modifiedRole, $userId);

    if ($stmt->execute()) {
        // Update was successful
        echo "User data updated successfully.";
    } else {
        // Update failed
        echo "Error updating user data: " . $stmt->error;
    }

    $stmt->close();
} else {
    // Handle invalid request (not a POST request)
    echo "Invalid request.";
}

// Close the database connection
$conn->close();
?>
