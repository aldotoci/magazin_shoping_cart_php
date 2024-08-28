<?php
// process_checkout.php

session_start();
include 'db.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Retrieve order details from the session
    $cart = isset($_SESSION['cart']) ? $_SESSION['cart'] : [];
    $categoryFilter = isset($_GET['category']) ? $_GET['category'] : '';

    // Validate and process the order
    if (!empty($cart)) {
        // Calculate total price
        $totalPrice = 0;
        foreach ($cart as $item) {
            $totalPrice += $item['quantity'] * $item['price'];
        }

        // Insert order into the database
        $insertOrderQuery = "INSERT INTO orders (magazine_name, quantity, price, total_price) VALUES (?, ?, ?, ?)";
        $stmt = $conn->prepare($insertOrderQuery);

        foreach ($cart as $item) {
            $stmt->bind_param("sidi", $item['magazine_name'], $item['quantity'], $item['price'], $totalPrice);
            $stmt->execute();
        }

        $stmt->close();

        // Clear the cart after processing the order
        unset($_SESSION['cart']);

        // Provide a confirmation message to the user
        $confirmationMessage = "Thank you for your order! Your total amount is $totalPrice. We will contact you shortly.";
    } else {
        $confirmationMessage = "Your cart is empty. Please add items to your cart before checking out.";
    }
} else {
    // Redirect back to the checkout page if the request method is not POST
    header("Location: /checkout.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Checkout Confirmation</title>
    <link rel="stylesheet" type="text/css" href="./styles/global.css">
    <link rel="stylesheet" type="text/css" href="./styles/process_checkout.css">
</head>
<body>
    <!-- Include common navbar -->
    <?php include 'navbar.php'; ?>

    <!-- Checkout Confirmation Message -->
    <div class="confirmation-container">
        <h2>Checkout Confirmation</h2>
        <p><?php echo $confirmationMessage; ?></p>
        <a href="/">Continue Shopping</a>
    </div>

    <!-- Footer -->
    <?php include 'footer.php'; ?>
</body>
</html>
