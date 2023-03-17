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

// Fetch items from database
$sql = "SELECT * FROM Items";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html>
<head>
    <title>Stock</title>
    <style>
        /* Define grid styles */
        .grid-container {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
            grid-gap: 20px;
        }
        .grid-item {
            border: 1px solid black;
            padding: 20px;
        }
        .delete-button {
            
            color: black;
            border: none;
            padding: 5px 10px;
            border-radius: 5px;
            cursor: pointer;
        }
    </style>
</head>
<body>
    <h2>Stock</h2>
    <a href="add_item.php">Add Item</a> &nbsp;
    <a href="update_items.php">Update Items</a>
    
    <!-- Display items in a grid -->
    <div class="grid-container">
        <?php
        if ($result->num_rows > 0) {
            // Output data of each row
            while($row = $result->fetch_assoc()) {
                echo '<div class="grid-item">';
                echo '<p>Item Code: ' . $row["Item_code"] . '</p>';
                echo '<p>Item Name: ' . $row["Item_name"] . '</p>';
                echo '<p>Quantity: ' . $row["Quantity"] . '</p>';
                echo '<p>Price: ' . $row["Price"] . '</p>';
                echo '<form method="POST">';
                echo '<input type="hidden" name="item_id" value="' . $row["Item_code"] . '">';
                echo '<button type="submit" name="delete_item" class="delete-button">Delete</button>';
                echo '</form>';
                echo '</div>';
            }
        } else {
            echo "No items found";
        }
        ?>
    </div>

    <?php
    // Handle item deletion
    if(isset($_POST['delete_item'])) {
        $item_id = $_POST['item_id'];
        $delete_sql = "DELETE FROM Items WHERE Item_code = '$item_id'";
        if($conn->query($delete_sql) === TRUE) {
            echo "<script>alert('Item deleted successfully')</script>";
            echo "<script>window.location.replace('stock.php')</script>";
        } else {
            echo "Error deleting item: " . $conn->error;
        }
    }

    // Close database connection
    $conn->close();
    ?>
</body>
</html>
