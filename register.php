<!DOCTYPE html>
<html>

<head>
    <title>Registration</title>
    <!-- Add Bootstrap CSS link -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
</head>

<body>
    <div class="container mt-5">
        <div class="row justify-content-center">
            <div class="col-md-6">
                <div class="card">
                    <div class="card-header">
                        <h2 class="text-center">S'enregistrer</h2>
                    </div>
                    <div class="card-body">
                        <form action="register_process.php" method="POST">
                            <div class="form-group">
                                <label for="username">Utilisateur:</label>
                                <input type="text" class="form-control" name="username" required="required">
                            </div>
                            <div class="form-group">
                                <label for="password">Clé d'accès:</label>
                                <input type="password" class="form-control" name="password" required="required">
                            </div>
                            <div class="form-group">
                                <label for="role">Rôle:</label>
                                <select class="form-control" name="role">
                                    <option value="user">User</option>
                                    <option value="admin">Admin</option>
                                </select>
                            </div>
                            <div class="form-group text-center">
                                <a href="index.php">Se connecter</a>
                            </div>
                            <div class="form-group text-center">
                                <input type="submit" class="btn btn-primary" value="Enregistrer">
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Add Bootstrap JS and jQuery links (optional) -->
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.3/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>

</html>
