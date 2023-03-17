<?php
// Start session
session_start();

// Define database connection variables
$servername = "localhost:3306";
$username_db = "easybrave_gehan";
$password_db = "Gehan123!";
$dbname = "easybrave_db";

// Create database connection
$conn = new mysqli($servername, $username_db, $password_db, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Check if user has submitted form
if (isset($_POST["submit"])) {
    // Get input values from form
    $username = $_POST["username"];
    $password = $_POST["password"];

    // Query database for user with matching username and password
    $sql = "SELECT * FROM Users WHERE Username='$username' AND Password='$password'";
    $result = $conn->query($sql);

    if ($result->num_rows == 1) {
        // If user was found, set session variable and redirect to stock page
        $_SESSION["username"] = $username;
        header("Location: stock.php");
        exit;
    } else {
        // If user was not found, display error message
        $error = "Invalid username or password";
    }
}

// Close database connection
$conn->close();
?>
<!DOCTYPE html>
<html>
<head>
    <title>Login Page</title>
    <link rel="stylesheet" type="text/css" href="login.css">
</head>
<body>
    <div class="container">
        <h2>Login Page</h2>
        <?php
        // If there is an error message, display it
        if (isset($error)) {
            echo "<p class='error'>$error</p>";
        }
        ?>
        <form method="post">
            <label for="username">Username:</label>
            <input type="text" name="username" required>
            <label for="password">Password:</label>
            <input type="password" name="password" required>
            <input type="submit" name="submit" value="Log in">
        </form>
    </div>
</body>
</html>
