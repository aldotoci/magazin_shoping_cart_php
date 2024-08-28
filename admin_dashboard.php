<?php
session_start();

// Check if the user is logged in as admin
if (!isset($_SESSION['admin']) || $_SESSION['admin'] !== true) {
    header('Location: admin_login.php');
    exit();
}

include 'db.php'; // Assuming you have a file to establish a database connection

// Fetch all orders from the database
$query = "SELECT * FROM orders";
$result = $conn->query($query);

// Fetch orders as an associative array
$orders = $result->fetch_all(MYSQLI_ASSOC);


include 'db.php';

// Fetch all magazines from the database
$query = "SELECT * FROM magazines";
$result = $conn->query($query);

// Fetch magazines as an associative array
$magazines = $result->fetch_all(MYSQLI_ASSOC);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard</title>
    <link rel="stylesheet" href="./styles/admin_dashboard.css">
</head>
<body>
    <div class="header">
        <h2>Admin Dashboard</h2>
        <a href="admin_logout.php">Logout</a>
    </div>  

    <br><br>

    <h3>All Orders</h3>
    <table border="1">
        <thead>
            <tr>
                <th>Order ID</th>
                <th>Magazine Name</th>
                <th>Quantity</th>
                <th>Price</th>
                <th>Total Price</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($orders as $order): ?>
                <tr>
                    <td><?php echo $order['id']; ?></td>
                    <td><?php echo $order['magazine_name']; ?></td>
                    <td><?php echo $order['quantity']; ?></td>
                    <td><?php echo $order['price']; ?></td>
                    <td><?php echo $order['total_price']; ?></td>
                    <td><a href="admin_remove_order.php?id=<?php echo $order['id']; ?>">Remove</a></td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>


    <h3>All Magazines</h3>
    <div class="table_container">
        <table>
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Name</th>
                    <th>Category</th>
                    <th>Language</th>
                    <th>Quantity</th>
                    <th>Price</th>
                    <th>Image</th>
                    <th>Add/Remove Quantity</th>
                    <th>Delete</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($magazines as $magazine): ?>
                    <tr>
                        <td><?php echo $magazine['id']; ?></td>
                        <td><?php echo $magazine['magazine_name']; ?></td>
                        <td><?php echo $magazine['category']; ?></td>
                        <td><?php echo $magazine['language']; ?></td>
                        <td><?php echo $magazine['quantity']; ?></td>
                        <td><?php echo $magazine['price']; ?></td>
                        <td><img src="<?php echo $magazine['image_url']; ?>" alt="Magazine Image" style="max-width: 100px;"></td>
                        <td>
                            <form method="post" action="admin_update_quantity.php">
                                <input type="hidden" name="id" value="<?php echo $magazine['id']; ?>">
                                <input type="number" name="quantity" value="1" min="1">
                                <button type="submit" name="action" value="add">Add</button>
                                <button type="submit" name="action" value="remove">Remove</button>
                            </form>
                        </td>
                        <td>
                            <form method="post" action="admin_delete_magazine.php">
                                <input type="hidden" name="id" value="<?php echo $magazine['id']; ?>">
                                <button type="submit">Delete</button>
                            </form>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>



    <h3>Add New Magazine</h3>
    <form method="post" action="admin_add_magazine.php">
        <label for="magazine_name">Magazine Name:</label>
        <input type="text" id="magazine_name" name="magazine_name" required>
        <br>
        <label for="category">Category:</label>
        <input type="text" id="category" name="category" required>
        <br>
        <label for="language">Language:</label>
        <input type="text" id="language" name="language" required>
        <br>
        <label for="quantity">Quantity:</label>
        <input type="number" id="quantity" name="quantity" required>
        <br>
        <label for="price">Price:</label>
        <input type="number" step="0.01" id="price" name="price" required>
        <br>
        <label for="image_url">Image URL:</label>
        <input type="text" id="image_url" name="image_url" required>
        <br>
        <button type="submit">Add Magazine</button>
    </form>
</body>
</html>
