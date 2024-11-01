<?php
session_start();

// Check if the user is logged in as a regular user
if (!isset($_SESSION["user_id"]) || $_SESSION["role"] !== "user") {
    header("Location: index.php");
    exit();
}
?>

<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>User Dashboard</title>
    <!-- Add Bootstrap CSS link -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <!-- Add custom CSS for the dashboard -->
    <style>
        body {
            background-color: #f8f9fa;
            padding: 20px;
        }

        .dashboard-container {
            background-color: #fff;
            border-radius: 5px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            padding: 20px;
        }

        .welcome-message {
            font-size: 24px;
            margin-bottom: 20px;
        }

        .logout-link {
            margin-top: 20px;
        }
    </style>
</head>

<body>
    <div class="container mt-5">
        <div class="dashboard-container">
            <h2 class="welcome-message">Welcome, <?php echo $_SESSION["username"]; ?> (User)</h2>
            <p>This is the user dashboard. You can view and manage your account here.</p>
            <a href="logout.php" class="btn btn-danger logout-link">Logout</a>
        </div>
    </div>

    <!-- Add Bootstrap JS and jQuery links (optional) -->
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.3/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>

</html>
