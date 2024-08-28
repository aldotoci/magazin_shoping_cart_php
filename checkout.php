<?php
session_start();
include 'db.php';

// Check if the user is authenticated
if (!isset($_SESSION['user_id'])) {
    header("Location: /login.php");
    exit();
}

// Get user ID from the session
$userId = $_SESSION['user_id'];

// Fetch cart items for the authenticated user from the order_items table
$fetchCartItemsQuery = "SELECT oi.*, m.magazine_name
                        FROM order_items oi
                        INNER JOIN magazines m ON oi.magazine_id = m.id
                        WHERE oi.user_id = ?";
$stmt = $conn->prepare($fetchCartItemsQuery);

if ($stmt === false) {
    die("Error in preparing statement: " . $conn->error);
}

$stmt->bind_param("i", $userId);

if ($stmt->execute() === false) {
    die("Error in executing statement: " . $stmt->error);
}

$result = $stmt->get_result();
$cartItems = $result->fetch_all(MYSQLI_ASSOC);

$stmt->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Checkout</title>
    <link rel="stylesheet" type="text/css" href="./styles/global.css">
    <link rel="stylesheet" type="text/css" href="./styles/checkout.css">
</head>
<body>
    <!-- Include common navbar -->
    <?php include 'navbar.php'; ?>

    <!-- Checkout Items -->
    <div>
        <h2>Checkout</h2>
        <table>
            <thead>
                <tr>
                    <th>Magazine</th>
                    <th>Quantity</th>
                    <th>Price</th>
                    <th>Total</th>
                </tr>
            </thead>
            <tbody>
                <?php
                $totalAmount = 0;

                foreach ($cartItems as $item) {
                    $totalAmount += $item['quantity'] * $item['price'];
                ?>
                    <tr>
                        <td><?php echo $item['magazine_name']; ?></td>
                        <td><?php echo $item['quantity']; ?></td>
                        <td>$<?php echo $item['price']; ?></td>
                        <td>$<?php echo $item['quantity'] * $item['price']; ?></td>
                    </tr>
                <?php
                }
                ?>
            </tbody>
        </table>

        <p>Total Amount: $<?php echo $totalAmount; ?></p>

        <!-- Add a form for further checkout actions (e.g., payment) -->
        <form method="post" action="/process_checkout.php">
            <!-- Add your checkout form fields here -->
            <button class="proceedButton" type="submit">Proceed to Payment</button>
        </form>
    </div>

    <!-- Footer -->
    <?php include 'footer.php'; ?>
</body>
</html>
