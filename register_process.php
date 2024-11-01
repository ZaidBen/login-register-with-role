<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST["username"];
    $password = $_POST["password"];
    $role = $_POST["role"];

    // Hash the password securely
    $hashed_password = password_hash($password, PASSWORD_DEFAULT);

    // Connect to the MySQL database
    $conn = new mysqli("localhost", "root", "E7DnO9eoP7Clc9Zw", "devprog_panel");

    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    // Check if the username is already taken
    $check_sql = "SELECT id FROM users WHERE username = ?";
    $check_stmt = $conn->prepare($check_sql);
    $check_stmt->bind_param("s", $username);
    $check_stmt->execute();
    $check_stmt->store_result();

    if ($check_stmt->num_rows > 0) {
        echo "Username already exists. Please choose a different username.";
    } else {
        // Insert the new user into the database
        $insert_sql = "INSERT INTO users (username, password, role) VALUES (?, ?, ?)";
        $insert_stmt = $conn->prepare($insert_sql);
        $insert_stmt->bind_param("sss", $username, $hashed_password, $role);

        if ($insert_stmt->execute()) {
            echo "<script>alert('Registration successful. You will be redirected to login.'); window.location.href = 'index.php';</script>";
        } else {
            echo "Error during registration. Please try again.";
        }
        
    }

    $check_stmt->close();
    $insert_stmt->close();
    $conn->close();
}
?>
