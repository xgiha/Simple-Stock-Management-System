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
    $item_code = $_POST["item_code"];
    $item_name = $_POST["item_name"];
    $quantity = $_POST["quantity"];
    $price = $_POST["price"];

    // Insert item into database
    $sql = "INSERT INTO Items (Item_code, Item_name, Quantity, Price) VALUES ('$item_code', '$item_name', '$quantity', '$price')";
    if ($conn->query($sql) === TRUE) {
        // If item was successfully inserted, redirect back to stock page
        header("Location: stock.php");
        exit;
    } else {
        // If item was not inserted, display error message
        $error = "Error adding item: " . $conn->error;
    }
}

// Close database connection
$conn->close();
?>
<!DOCTYPE html>
<html>
<head>
    <title>Add Item</title>
</head>
<body>
    <h2>Add Item</h2>
    <?php
    // If there is an error message, display it
    if (isset($error)) {
        echo "<p class='error'>$error</p>";
    }
    ?>
    <form method="post">
        <label for="item_code">Item Code:</label>
        <input type="text" name="item_code" required><br><br>
        <label for="item_name">Item Name:</label>
        <input type="text" name="item_name" required><br><br>
        <label for="quantity">Quantity:</label>
        <input type="number" name="quantity" required><br><br>
        <label for="price">Price:</label>
        <input type="number" step="0.01" name="price" required><br><br>
        <input type="submit" name="submit" value="Add Item">
    </form>
</body>
</html>
