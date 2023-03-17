<?php
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

// Initialize variables
$item_code = "";
$item_name = "";
$quantity = "";
$price = "";
$error_message = "";

// Handle form submission
if(isset($_POST['update_item'])) {
    $item_code = $_POST['item_code'];
    $item_name = $_POST['item_name'];
    $quantity = $_POST['quantity'];
    $price = $_POST['price'];

    // Validate input
    if(empty($item_name)) {
        $error_message = "Item name is required";
    } elseif(empty($quantity)) {
        $error_message = "Quantity is required";
    } elseif(empty($price)) {
        $error_message = "Price is required";
    } elseif(!is_numeric($quantity) || !is_numeric($price)) {
        $error_message = "Quantity and price must be numeric";
    } else {
        // Update item in database
        $update_sql = "UPDATE Items SET Item_name = '$item_name', Quantity = $quantity, Price = $price WHERE Item_code = '$item_code'";
        if($conn->query($update_sql) === TRUE) {
            echo "<script>alert('Item updated successfully')</script>";
        } else {
            echo "Error updating item: " . $conn->error;
        }
    }
}

// Close database connection
$conn->close();
?>

<!DOCTYPE html>
<html>
<head>
    <title>Update Item</title>
</head>
<body>
    <h2>Update Item</h2>
    <?php if(!empty($error_message)): ?>
        <p style="color: red;"><?php echo $error_message; ?></p>
    <?php endif; ?>
    <form method="POST">
        <label>Item Code:</label>
        <input type="text" name="item_code" value="<?php echo $item_code; ?>"><br><br>
        <label>Item Name:</label>
        <input type="text" name="item_name" value="<?php echo $item_name; ?>"><br><br>
        <label>Quantity:</label>
        <input type="text" name="quantity" value="<?php echo $quantity; ?>"><br><br>
        <label>Price:</label>
        <input type="text" name="price" value="<?php echo $price; ?>"><br><br>
        <button type="submit" name="update_item">Update</button>
    </form>
</body>
</html>
