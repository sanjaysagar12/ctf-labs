<?php
session_start();

// Check if user is logged in
if (!isset($_SESSION['secure_user'])) {
    header("Location: index.php");
    exit();
}

$username = $_SESSION['secure_user'];
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User Profile</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <div class="container mt-5">
        <h1 class="mb-4">Welcome, <?php echo htmlspecialchars($username); ?>!</h1>
        <div class="card">
            <div class="card-body">
                <h5 class="card-title">Your Profile</h5>
                <p class="card-text">This is a simple profile page. In a real application, you would display user-specific information here.</p>
            </div>
        </div>
        <a href="logout.php" class="btn btn-primary mt-3">Logout</a>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>