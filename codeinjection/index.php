<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ping Host</title>
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 20px;
            padding: 0;
        }
        form {
            margin-bottom: 20px;
        }
        input[type="text"] {
            width: 300px;
            padding: 8px;
            margin-right: 10px;
            border: 1px solid #ccc;
            border-radius: 4px;
        }
        input[type="submit"] {
            padding: 8px 16px;
            border: none;
            background-color: #28a745;
            color: white;
            border-radius: 4px;
            cursor: pointer;
        }
        input[type="submit"]:hover {
            background-color: #218838;
        }
        pre {
            background-color: #f8f9fa;
            padding: 15px;
            border: 1px solid #ddd;
            border-radius: 4px;
            max-width: 600px;
            overflow-x: auto;
        }
        .spinner-container {
            display: none;
            text-align: center;
            margin-top: 20px;
        }
    </style>
</head>
<body>

    <h1>Ping a Host</h1>

    <!-- Form to enter the host to ping -->
    <form id="pingForm" action="index.php" method="GET">
        <input type="text" name="host" placeholder="Enter host (e.g., google.com)" required>
        <input type="submit" value="Ping">
    </form>

    <!-- Loading spinner -->
    <div class="spinner-container" id="spinner">
        <div class="spinner-border text-primary" role="status">
            <span class="sr-only">Loading...</span>
        </div>
    </div>

    <?php
    // Vulnerable function to handle the ping functionality
    function pingHost() {
        if (isset($_GET['host'])) {
            // Get the user input directly without any sanitization
            $host = $_GET['host'];

            // Code Injection Vulnerability: Unsafe direct execution of user input
            $command = "ping -c 4 " . escapeshellarg($host);
            $output = shell_exec($command);

            if ($output === null) {
                echo "Ping execution failed.";
            } else {
                echo "<h2>Ping result for: $host</h2>";
                echo "<pre>" . htmlspecialchars($output) . "</pre>";
            }
        }
    }

    // Call the function to handle the ping request
    pingHost();
    ?>

    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.4/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    <script>
        document.getElementById('pingForm').addEventListener('submit', function() {
            document.getElementById('spinner').style.display = 'block';
        });
    </script>

</body>
</html>
