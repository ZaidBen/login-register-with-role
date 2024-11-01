<?php
session_start();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST["username"];
    $password = $_POST["password"];

    // Connect to the MySQL database
    $conn = new mysqli("localhost", "root", "E7DnO9eoP7Clc9Zw", "devprog_panel");

    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    $sql = "SELECT id, username, password, role FROM users WHERE username = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $username);
    $stmt->execute();
    $stmt->store_result();

    if ($stmt->num_rows === 1) {
        $stmt->bind_result($id, $username, $hashed_password, $role);
        $stmt->fetch();
        
        if (password_verify($password, $hashed_password)) {
            $_SESSION["user_id"] = $id;
            $_SESSION["username"] = $username;
            $_SESSION["role"] = $role;

            if ($role === "admin") {
                header("Location: admin_view.php");
            } else {
                header("Location: user_view.php");
            }
        } else {
            echo "Incorrect password.";
        }
    } else {
        echo "<script>alert('username not registered.'); window.location.href = 'index.php';</script>";
    }

    $stmt->close();
    $conn->close();
}
?>
