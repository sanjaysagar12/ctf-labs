<?php
session_start();

// NOTE: This script contains intentional vulnerabilities for educational purposes.
// DO NOT use the vulnerable parts in a real-world application.

// Database connection using environment variables
$servername = getenv('DB_HOST');
$username = getenv('DB_USER');
$password = getenv('DB_PASSWORD');
$dbname = getenv('DB_NAME');

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

function showAlert($message, $type) {
    return "<div class='alert alert-$type' role='alert'>$message</div>";
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST['username'];
    $password = $_POST['password'];

    // SECURE METHOD USING PREPARED STATEMENTS
    $secure_query = "SELECT * FROM users WHERE username=? AND password=?";
    $stmt = $conn->prepare($secure_query);
    $stmt->bind_param("ss", $username, $password);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $secureResult = showAlert("Login successful (secure method)", "success");
        $_SESSION['secure_user'] = $username;
        header("Location: profile.php");
        exit();
    } else {
        $secureResult = showAlert("Login failed (secure method)", "danger");
    }

    $stmt->close();
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login System - SQL Injection Demo</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <div class="container mt-5">
        <h1 class="mb-4">Login System - SQL Injection Demo</h1>
        
        <form method="POST" action="<?php echo $_SERVER['PHP_SELF']; ?>" class="mb-4">
            <div class="mb-3">
                <label for="username" class="form-label">Username:</label>
                <input type="text" class="form-control" id="username" name="username" required>
            </div>
            <div class="mb-3">
                <label for="password" class="form-label">Password:</label>
                <input type="password" class="form-control" id="password" name="password" required>
            </div>
            <button type="submit" class="btn btn-primary">Login</button>
        </form>

        <?php
        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            echo "<h2>Results:</h2>";
            echo $secureResult;
            echo "<h3>Queries Used:</h3>";
            echo "<pre>Secure: " . htmlspecialchars($secure_query) . "</pre>";
        }
        ?>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>