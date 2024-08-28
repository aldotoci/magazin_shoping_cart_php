<?php
session_start();

// Check if the user is logged in as admin
if (!isset($_SESSION['admin']) || $_SESSION['admin'] !== true) {
    header('Location: admin_login.php');
    exit();
}

include 'db.php'; // Assuming you have a file to establish a database connection

if ($_SERVER['REQUEST_METHOD'] == 'GET' && isset($_GET['id'])) {
    $orderId = $_GET['id'];

    // Perform the removal of the order from the database
    $deleteQuery = "DELETE FROM orders WHERE id = ?";
    $stmt = $conn->prepare($deleteQuery);
    $stmt->bind_param("i", $orderId);
    $stmt->execute();
    $stmt->close();

    header('Location: admin_dashboard.php');
    exit();
} else {
    // Redirect to the dashboard if no order ID is provided
    header('Location: admin_dashboard.php');
    exit();
}
?>
