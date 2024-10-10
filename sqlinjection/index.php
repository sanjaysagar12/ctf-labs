<?php
session_start();

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

$vulnerableResult = $secureResult = '';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST['username'];
    $password = $_POST['password'];
    // VULNERABLE METHOD - DO NOT USE IN PRODUCTION
    $vulnerable_query = "SELECT * FROM users WHERE username='$username' AND password='$password'";
    $result = $conn->query($vulnerable_query);

    if ($result->num_rows > 0) {
        $_SESSION['secure_user'] = $username;
        header("Location: profile.php");
        exit();
    } else {
        $vulnerableResult = showAlert("Login failed (vulnerable method)", "danger");
    }
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
    <style>
        body {
            background-color: #f8f9fa;
            font-family: 'Arial', sans-serif;
        }
        .login-container {
            max-width: 400px;
            margin: auto;
            margin-top: 100px;
            background: white;
            padding: 30px;
            border-radius: 10px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }
        h1 {
            text-align: center;
            margin-bottom: 30px;
            font-size: 1.8rem;
        }
        .btn-primary {
            background-color: #007bff;
            border: none;
            padding: 10px;
            width: 100%;
            font-size: 1.2rem;
        }
        .btn-primary:hover {
            background-color: #0056b3;
        }
    </style>
</head>
<body>
    <div class="container login-container">
        <h1>Login System</h1>
        
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
            echo $vulnerableResult;
            echo $secureResult;
            echo "<h3>Queries Used:</h3>";
            echo "<pre>Vulnerable: " . htmlspecialchars($vulnerable_query) . "</pre>";
        }
        ?>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
